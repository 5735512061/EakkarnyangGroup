<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Model\EmployeeWork;
use App\Model\Dayoff;
use App\Model\Salary;
use App\Model\Fund;
use App\Model\Leave;
use App\Model\Evaluation;
use App\Model\EmployeeRate;
use App\Employee;
use App\Model\EmployeeBenefit;
use App\Model\Position;
use App\Model\EvaluationManager;
use App\Model\ManagerRate;
use Carbon\Carbon;
use App\Model\ElearningStatistic;

class StaffController extends Controller
{

    public function __construct(){
        $this->middleware('auth:staff');
    }

    public function dashboard() {

        $staff = Auth::guard('staff')->user();
        $year = EmployeeWork::where('employee_id',$staff->id)->orderBy('id','desc')->value('year');
        // $year = ปีปัจจุบัน, $absence = จำนวนวันที่หยุด, $late = จำนวนวันที่สาย, $lateBalance = วันที่สายคงเหลือ, $absenceTotal = วันหยุดรวมทั้งหมด
        // $dayoff = วันหยุดประจำปี, $absenceBalance = วันหยุดคงเหลือ, $bonus = โบนัสรายปี

        $absence = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('absence'); // หยุด
        $late = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('late'); // สาย
        $dayoff = Dayoff::where('employee_id',$staff->id)->where('year',$year)->value('dayoff'); // วันหยุดประจำปี

            if($late > 3) { // ถ้าหยุดมากกว่า 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else if($late == 3) { // ถ้าสาย 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else { // หยุดน้อยกว่า 3 วัน
                $lateBalance = $late; // สาย
                $absenceTotal = $absence; // หยุด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            }
        
        $salary = Salary::where('employee_id',$staff->id)->where('year',$year)->orderBy('id','desc')->value('salary');

            if($absenceBalance >= 0) {
                $bonus = $salary;
            } else {
                $bonus = 0;
            }

        return view('frontend/employee/dashboard')->with('staff',$staff)
                                                  ->with('absence',$absence)
                                                  ->with('late',$late)
                                                  ->with('lateBalance',$lateBalance)
                                                  ->with('absenceTotal',$absenceTotal)
                                                  ->with('absenceBalance',$absenceBalance)
                                                  ->with('bonus',$bonus);
    }

    public function profile(Request $request) {
        $staff = Auth::guard('staff')->user();

        $year = EmployeeWork::where('employee_id',$staff->id)->orderBy('id','desc')->value('year');

        // $year = ปีปัจจุบัน, $absence = จำนวนวันที่หยุด, $late = จำนวนวันที่สาย, $lateBalance = วันที่สายคงเหลือ, $absenceTotal = วันหยุดรวมทั้งหมด
        // $dayoff = วันหยุดประจำปี, $absenceBalance = วันหยุดคงเหลือ, $bonus = โบนัสรายปี

        $absence = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('absence'); // หยุด
        $late = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('late'); // สาย
        $dayoff = Dayoff::where('employee_id',$staff->id)->where('year',$year)->value('dayoff'); // วันหยุดประจำปี

            if($late > 3) { // ถ้าหยุดมากกว่า 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else if($late == 3) { // ถ้าสาย 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else { // หยุดน้อยกว่า 3 วัน
                $lateBalance = $late; // สาย
                $absenceTotal = $absence; // หยุด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            }
        
        $salary = Salary::where('employee_id',$staff->id)->where('year',$year)->value('salary');

            if($absenceBalance >= 0) {
                $bonus = $salary;
            } else {
                $bonus = 0;
            }

        return view('frontend/employee/information/profile')->with('staff',$staff)
                                                            ->with('absence',$absence)
                                                            ->with('late',$late)
                                                            ->with('lateBalance',$lateBalance)
                                                            ->with('absenceTotal',$absenceTotal)
                                                            ->with('absenceBalance',$absenceBalance)
                                                            ->with('bonus',$bonus);
    }

    public function workInformation(Request $request) {
        $NUM_PAGE = 15;
        $staff = Auth::guard('staff')->user();

        $year = EmployeeWork::where('employee_id',$staff->id)->orderBy('id','desc')->value('year');
        $works = EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->paginate($NUM_PAGE);
        $page = $request->input('page');
        $page = ($page != null)?$page:1;

        // $year = ปีปัจจุบัน, $absence = จำนวนวันที่หยุด, $late = จำนวนวันที่สาย, $lateBalance = วันที่สายคงเหลือ, $absenceTotal = วันหยุดรวมทั้งหมด
        // $dayoff = วันหยุดประจำปี, $absenceBalance = วันหยุดคงเหลือ, $bonus = โบนัสรายปี

        $absence = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('absence'); // หยุด
        $late = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('late'); // สาย
        $dayoff = Dayoff::where('employee_id',$staff->id)->where('year',$year)->value('dayoff'); // วันหยุดประจำปี

            if($late > 3) { // ถ้าหยุดมากกว่า 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else if($late == 3) { // ถ้าสาย 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else { // หยุดน้อยกว่า 3 วัน
                $lateBalance = $late; // สาย
                $absenceTotal = $absence; // หยุด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            }
        
        $salary = Salary::where('employee_id',$staff->id)->where('year',$year)->orderBy('id','desc')->value('salary');

            if($absenceBalance >= 0) {
                $bonus = $salary;
            } else {
                $bonus = 0;
            }
        
        $funds = Fund::where('employee_id',$staff->id)->orderBy('id','asc')->get();  //เงินกองทุนสะสม

        // คำนวณจำนวนปีที่ทำงาน เพื่อนำไปคำนวณเปอร์เซ็นต์
            $startdate = Employee::where('id',$staff->id)->value('startdate');
            $startdate = strtr($startdate,'/','-');
            $startdate_d = date('d',strtotime($startdate));
            $startdate_m = date('m',strtotime($startdate));
            $startdate_y = date('Y',strtotime($startdate));
            
            $date = Carbon::parse($startdate_y."-".$startdate_m."-".$startdate_d);
            $now = Carbon::now();
            $diff = $date->diffInDays($now);    
            $year_work = intval($diff/365);
        // จบ

        return view('frontend/employee/work-information')->with('NUM_PAGE',$NUM_PAGE)
                                                         ->with('page',$page)
                                                         ->with('staff',$staff)
                                                         ->with('works',$works)
                                                         ->with('absence',$absence)
                                                         ->with('late',$late)
                                                         ->with('lateBalance',$lateBalance)
                                                         ->with('absenceTotal',$absenceTotal)
                                                         ->with('absenceBalance',$absenceBalance)
                                                         ->with('bonus',$bonus)
                                                         ->with('funds',$funds)    
                                                         ->with('year_work',$year_work);
    }

    public function salaryInformation() {
        $staff = Auth::guard('staff')->user();
        $salarys = Salary::where('employee_id',$staff->id)->get();

        // $year = ปีปัจจุบัน, $absence = จำนวนวันที่หยุด, $late = จำนวนวันที่สาย, $lateBalance = วันที่สายคงเหลือ, $absenceTotal = วันหยุดรวมทั้งหมด
        // $dayoff = วันหยุดประจำปี, $absenceBalance = วันหยุดคงเหลือ

        $year = EmployeeWork::where('employee_id',$staff->id)->orderBy('id','desc')->value('year');

        $absence = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('absence'); // หยุด
        $late = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('late'); // สาย
        $dayoff = Dayoff::where('employee_id',$staff->id)->where('year',$year)->value('dayoff'); // วันหยุดประจำปี

            if($late > 3) { // ถ้าหยุดมากกว่า 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else if($late == 3) { // ถ้าสาย 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else { // หยุดน้อยกว่า 3 วัน
                $lateBalance = $late; // สาย
                $absenceTotal = $absence; // หยุด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            }
        
        $salary = Salary::where('employee_id',$staff->id)->where('year',$year)->value('salary');

            if($absenceBalance >= 0) {
                $bonus = $salary;
            } else {
                $bonus = 0;
            }

        return view('frontend/employee/salary-information')->with('staff',$staff)
                                                           ->with('salarys',$salarys)
                                                           ->with('absence',$absence)
                                                           ->with('late',$late)
                                                           ->with('lateBalance',$lateBalance)
                                                           ->with('absenceTotal',$absenceTotal)
                                                           ->with('absenceBalance',$absenceBalance)
                                                           ->with('bonus',$bonus);
    }

    public function providentFundInformation() {
        $staff = Auth::guard('staff')->user();
        $funds = Fund::where('employee_id',$staff->id)->orderBy('id','asc')->get();  

        // $year = ปีปัจจุบัน, $absence = จำนวนวันที่หยุด, $late = จำนวนวันที่สาย, $lateBalance = วันที่สายคงเหลือ, $absenceTotal = วันหยุดรวมทั้งหมด
        // $dayoff = วันหยุดประจำปี, $absenceBalance = วันหยุดคงเหลือ

        $year = EmployeeWork::where('employee_id',$staff->id)->orderBy('id','desc')->value('year');

        $absence = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('absence'); // หยุด
        $late = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('late'); // สาย
        $dayoff = Dayoff::where('employee_id',$staff->id)->where('year',$year)->value('dayoff'); // วันหยุดประจำปี

            if($late > 3) { // ถ้าหยุดมากกว่า 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else if($late == 3) { // ถ้าสาย 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else { // หยุดน้อยกว่า 3 วัน
                $lateBalance = $late; // สาย
                $absenceTotal = $absence; // หยุด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            }
        
        $salary = Salary::where('employee_id',$staff->id)->where('year',$year)->value('salary');

            if($absenceBalance >= 0) {
                $bonus = $salary;
            } else {
                $bonus = 0;
            }

        return view('frontend/employee/provident-fund-information')->with('staff',$staff)
                                                                   ->with('funds',$funds)
                                                                   ->with('absence',$absence)
                                                                   ->with('late',$late)
                                                                   ->with('lateBalance',$lateBalance)
                                                                   ->with('absenceTotal',$absenceTotal)
                                                                   ->with('absenceBalance',$absenceBalance)
                                                                   ->with('bonus',$bonus);
    }

    public function leaveWork(Request $request) {
        $NUM_PAGE = 20;

        $staff = Auth::guard('staff')->user();
        $salarys = Salary::where('employee_id',$staff->id)->get();

        // $year = ปีปัจจุบัน, $absence = จำนวนวันที่หยุด, $late = จำนวนวันที่สาย, $lateBalance = วันที่สายคงเหลือ, $absenceTotal = วันหยุดรวมทั้งหมด
        // $dayoff = วันหยุดประจำปี, $absenceBalance = วันหยุดคงเหลือ

        $year = EmployeeWork::where('employee_id',$staff->id)->orderBy('id','desc')->value('year');

        $absence = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('absence'); // หยุด
        $late = (int)EmployeeWork::where('employee_id',$staff->id)->where('year',$year)->sum('late'); // สาย
        $dayoff = Dayoff::where('employee_id',$staff->id)->where('year',$year)->value('dayoff'); // วันหยุดประจำปี

            if($late > 3) { // ถ้าหยุดมากกว่า 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else if($late == 3) { // ถ้าสาย 3 วัน
                $lateBalance = $late%3; // สายคงเหลือ
                $absenceTotal = $absence + (($late-$lateBalance)/3); // วันหยุดรวมทั้งหมด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            } else { // หยุดน้อยกว่า 3 วัน
                $lateBalance = $late; // สาย
                $absenceTotal = $absence; // หยุด
                $absenceBalance = $dayoff - $absenceTotal; // วันหยุดคงเหลือ
            }
        
        $salary = Salary::where('employee_id',$staff->id)->where('year',$year)->value('salary');

            if($absenceBalance >= 0) {
                $bonus = $salary;
            } else {
                $bonus = 0;
            }

        $leave_days = Dayoff::where('employee_id',$staff->id)->orderBy('id','desc')->get(); // จำนวนวันหยุด

        $leave_works = Leave::where('employee_id',$staff->id)->orderBy('id','asc')->get(); // ข้อมูลการลา

        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('frontend/employee/leave-work')->with('NUM_PAGE',$NUM_PAGE)
                                                   ->with('page',$page)
                                                   ->with('staff',$staff)
                                                   ->with('salarys',$salarys)
                                                   ->with('absence',$absence)
                                                   ->with('late',$late)
                                                   ->with('lateBalance',$lateBalance)
                                                   ->with('absenceTotal',$absenceTotal)
                                                   ->with('absenceBalance',$absenceBalance)
                                                   ->with('bonus',$bonus)
                                                   ->with('leave_days',$leave_days)
                                                   ->with('leave_works',$leave_works);
    }

    public function benefit() {
        $staff = Auth::guard('staff')->user();
        $benefits = EmployeeBenefit::where('employee_id',$staff->id)->orderBy('id','desc')->get();
        return view('frontend/employee/benefit/benefit-index')->with('staff',$staff)
                                                              ->with('benefits',$benefits);
    }

    public function useBenefit(Request $request, $id) {
        $employee_benefit = EmployeeBenefit::findOrFail($id);
        $employee_benefit->status = "กดรับสิทธิ์";
        $employee_benefit->update();
        $request->session()->flash('alert-success', 'คุณได้กดรับสิทธิ์เรียบร้อยแล้ว');
        return back();
    }

    public function leaveWorkPost(Request $request) {
        $leave_work = $request->all();
        $leave_work = Leave::create($leave_work);
        $request->session()->flash('alert-success', 'ยื่นใบลาสำเร็จ รออนุมัติจากฝ่ายบุคคล');
        return back();
    }

    public function listEmployeeEvaluate(Request $request) {
        $NUM_PAGE = 20;
        $branch_id = Auth::guard('staff')->user()->branch_id;   

        $employees = Employee::join('positions', 'employees.position_id', '=', 'positions.id')
                             ->select('employees.*', 'positions.position')   
                             ->where('branch_id',$branch_id)
                             ->where('positions.position','!=','MANAGER')
                             ->where('employees.status','เปิด')
                             ->paginate($NUM_PAGE);

        $dateNow = Carbon::now()->format('d/m/Y');
        $page = $request->input('page');
        $page = ($page != null)?$page:1;
        return view('frontend/employee/evaluate/list-employee')->with('NUM_PAGE',$NUM_PAGE)
                                                               ->with('page',$page)
                                                               ->with('employees',$employees)
                                                               ->with('branch_id',$branch_id)
                                                               ->with('dateNow',$dateNow);
    }

    public function formEmployeeEvaluate($id) {
        $employee = Employee::findOrFail($id);
        $date = Carbon::now()->format('m');
        $evaluations = Evaluation::where('status',"เปิด")->get();
        return view('frontend/employee/evaluate/form-employee-evaluate')->with('employee',$employee)
                                                                        ->with('date',$date)
                                                                        ->with('evaluations',$evaluations);
    }

    public function formEmployeeEvaluatePost(Request $request) {
        $rate = $request->all();

        foreach($rate['list'] as $key => $value) {
            $employee_id = $request->get('employee_id');
            $date = Carbon::now()->format('d/m/Y');
            $evaluation_id = $key;
            $rate = $value;
            $comment = $request->get('comment');

            $rate_data = new EmployeeRate;
            $rate_data->employee_id = $employee_id;
            $rate_data->evaluation_id = $evaluation_id;
            $rate_data->rate = $rate;
            $rate_data->date = $date;
            $rate_data->comment = $comment;
            $rate_data->save();
        }
        return redirect()->action('Frontend\\StaffController@listEmployeeEvaluate');
    }

    public function formManagerEvaluate() {
        $employee = Auth::guard('staff')->user();
        $position_id = Position::where('branch_group_id',$employee->branch_id)->where('position',"MANAGER")->value('id');
        $employees = Employee::where('position_id','=',$position_id)
                             ->where('branch_id','=',$employee->branch_id)->get();
        $dateM = Carbon::now()->format('m');
        $dateNow = Carbon::now()->format('d/m/Y');
        $evaluations = EvaluationManager::where('status',"เปิด")->get();
        return view('frontend/employee/evaluate/form-manager-evaluate')->with('employees',$employees)
                                                                       ->with('dateM',$dateM)
                                                                       ->with('dateNow',$dateNow)
                                                                       ->with('evaluations',$evaluations);

    }

    public function formManagerEvaluatePost(Request $request) {
        $rate = $request->all();
        $comment = $request->get('comment');

        foreach($rate['list'] as $key => $value) {
            $manager_id = $request->get('manager_id');
            $comment = $request->get('comment');
            $employee_id = $request->get('employee_id');
            $date = Carbon::now()->format('d/m/Y');
            $evaluation_id = $key;
            $rate = $value;

            $rate_data = new ManagerRate;
            $rate_data->manager_id = $manager_id;
            $rate_data->employee_id = $employee_id;
            $rate_data->evaluation_id = $evaluation_id;
            $rate_data->rate = $rate;
            $rate_data->date = $date;
            $rate_data->comment = $comment;
            $rate_data->save();
        }
        return redirect()->action('Frontend\\StaffController@dashboard');
    }

    public function Elearning(Request $request) {
        $staff_id = Auth::guard('staff')->id();
        $date = Carbon::now()->format('d/m/Y');

        $count = ElearningStatistic::where('staff_id',$staff_id)->orderBy('id','desc')->value('count');
        $date_statistic = ElearningStatistic::where('staff_id',$staff_id)->orderBy('id','desc')->value('date');
        $id = ElearningStatistic::where('staff_id',$staff_id)->orderBy('id','desc')->value('id');
        $staff_id_statistic = ElearningStatistic::where('staff_id',$staff_id)->orderBy('id','desc')->value('staff_id');

        if($date_statistic == $date && $staff_id_statistic == $staff_id) {
            $statistic = ElearningStatistic::findOrFail($id);
            $statistic->count = $count+1;
            $statistic->update();
        } else {
            $statistic = new ElearningStatistic;
            $statistic->staff_id = $staff_id;
            $statistic->date = $date;
            $statistic->count = 1;
            $statistic->save();
        }

        return back();
    }

    public function rules() {
        return view('frontend/company/rules');
    }
}

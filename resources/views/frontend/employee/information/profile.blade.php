@extends("frontend/layouts/employee/template") 

@section("content")

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-4">
            <a class="btn btn-success mb-4" style="width: 100%; font-family:'Sarabun'; color:#fff;" data-bs-toggle="modal" data-bs-target="#backDropModal" data-bs-toggle="modal" data-bs-target="#backDropModal">
                แสดงบัตรพนักงาน
            </a>
            <div class="modal fade" id="backDropModal" data-bs-backdrop="static" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <form action="#" method="POST" enctype="multipart/form-data" class="modal-content">@csrf
                        @php
                            $position = DB::table('positions')->where('id',$staff->position_id)->value('position');
                            $branch = DB::table('branch_groups')->where('id',$staff->branch_id)->value('branch');
                            $datenow = Carbon\Carbon::now()->format('d/m/Y H:i:s');
                        @endphp
                        {{-- <div style="text-align:end;"><button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button></div> --}}
                        <div class="modal-header" style="margin-top: -30px; background: radial-gradient(ellipse farthest-corner at 0 140%, #4CAF50 0%, #4CAF50 70%, #8BC34A 70%)">
                            <center><img src="{{url('image/logo_store/eakkarnyang_logo.png')}}" width="40%"/></center>
                        </div>
                        <div class="modal-body">
                            <body style="background: linear-gradient(150deg, #8bc34a 40%, #ffffff 40%);"></body>
                            {{-- style="background: linear-gradient(150deg, #389b38 40%, #ffffff 40%);" --}}
                            <center><img src="{{url('img_upload/employee-profile')}}/{{$staff->image}}" alt="profile" width="50%"/></center><br>
                            <center><h5 style="line-height: 0.8; !important">{{$staff->name}} {{$staff->surname}} ({{$staff->nickname}})</h5></center>
                            <center><h6 style="color: #006a00; line-height: 0.8; !important">ตำแหน่ง : {{$position}}</h6></center>
                            <center><h6 style="color: #006a00; line-height: 0.8; !important">{{$branch}}</h6></center>
                            <center><h6 style="color: rgb(255, 0, 0); line-height: 0.8; !important">{{$datenow}}</h6></center>
                        </div>
                        <div class="modal-footer" style="background-color: #389b38; justify-content:center !important; padding: 0.25rem 1.5rem 0.5rem !important;">
                            <h6 style="color:#fff;">ไทร์พลัส เอกการยาง</h6> 
                        </div>
                    </form>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <center>
                        <div class="align-items-start align-items-sm-center gap-4">
                            @if($staff->image == NULL)
                                <img src="{{ asset('/assets/img/avatars/profile.png')}}" alt="profile" width="50%"/>
                            @else
                                <img src="{{url('img_upload/employee-profile')}}/{{$staff->image}}" alt="profile" width="50%"/>
                            @endif
                        </div>
                        @php
                            $position = DB::table('positions')->where('id',$staff->position_id)->value('position');
                            $branch = DB::table('branch_groups')->where('id',$staff->branch_id)->value('branch');
                        @endphp
                        <h4 style="margin-top: 10px;">{{$staff->name}} {{$staff->surname}} ( {{$staff->nickname}} ) ตำแหน่งงาน : {{$position}}</h4>
                        <p>{{$branch}}</p>
                        @php
                            $dayoff = DB::table('dayoffs')->where('employee_id',$staff->id)->orderBy('id','desc')->first();
                        @endphp

                        @if($dayoff != NULL)
                            <div>
                                <i class="ni education_hat mr-2"></i>วันหยุดที่ได้รับ : {{$dayoff->dayoff}} วัน/ปี
                            </div>

                            @if($bonus != 0)
                            <h4>
                                <i class="ni education_hat mr-2"></i>วันหยุดคงเหลือ : {{$absenceBalance}} วัน/ปี
                            </h4>
                            @else 
                                <h4 style="color:red;"><i class="ni education_hat mr-2"></i>ใช้วันหยุดเกิน : {{abs($absenceBalance)}} วัน</h3>
                            @endif
                            <p style="color:red;">ขาดงาน {{$absence}} วัน สาย {{$late}} วัน <br>สรุป : ขาดงาน {{$absenceTotal}} วัน สาย {{$lateBalance}} วัน</p>
                        @else 
                            <a href="{{url('/staff/staff-dayoff')}}">กรอกวันหยุดประจำปี</a><br>
                        @endif
                    </center>
                </div>
                <hr class="my-0" />
            </div> 
        </div>
        <div class="col-md-8">
            <div class="card mb-4" style="margin-bottom: 100px;">
                <div class="card-body">
                    <h5 class="card-header">ข้อมูลส่วนตัว</h5><hr class="my-0" />
                    <div class="row">
                        <div class="mb-3 mt-3 col-md-6">
                            <input class="form-control" type="text" value="ชื่อ : {{$staff->name}} {{$staff->surname}}"/>
                        </div>
                        <div class="mb-3 mt-3 col-md-6">
                            <input class="form-control" type="text" value="หมายเลขบัตรประชาชน : {{$staff->idcard}}"/>
                        </div>
                        <div class="mb-3 mt-3 col-md-6">
                            <input class="form-control" type="text" value="วัน/เดือน/ปีเกิด : {{$staff->bday}}"/>
                        </div>
                        <div class="mb-3 mt-3 col-md-6">
                            <input class="form-control" type="text" value="เบอร์โทรศัพท์ : {{$staff->tel}}"/>
                        </div>
                        <div class="mb-3 mt-3 col-md-6">
                            <input class="form-control" type="text" value="วันที่เริ่มงาน : {{$staff->startdate}}"/>
                        </div>
                        <div class="mb-3 mt-3 col-md-6">
                            @php
                                $salary = DB::table('salarys')->where('employee_id',$staff->id)->orderBy('id','desc')->first();
                            @endphp
                            @if($salary != NULL)
                                <input class="form-control" type="text" value="เงินเดือนปัจจุบัน : {{number_format((float)$salary->salary)}} บาท"/>
                            @else 
                                0
                            @endif
                        </div>
                        <div class="mb-3 mt-3 col-md-12">
                            <input class="form-control" type="text" value="ที่อยู่ : {{$staff->address}} ตำบล{{$staff->district}} อำเภอ{{$staff->amphoe}} จังหวัด{{$staff->province}} {{$staff->zipcode}}"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
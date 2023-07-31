@extends("frontend/layouts/employee/template") 
<style>
    /* The container */
    .containerRadio {
      display: block;
      position: relative;
      padding-left: 35px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 22px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      font-size: 16px;
    }
    
    /* Hide the browser's default radio button */
    .containerRadio input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
    }
    
    /* Create a custom radio button */
    .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 20px;
      width: 20px;
      background-color: #bec7d0;
      border-radius: 50%;
    }
    
    /* On mouse-over, add a grey background color */
    .containerRadio:hover input ~ .checkmark {
      background-color: #ccc;
    }
    
    /* When the radio button is checked, add a blue background */
    .containerRadio input:checked ~ .checkmark {
      background-color: #2196F3;
    }
    
    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }
    
    /* Show the indicator (dot/circle) when checked */
    .containerRadio input:checked ~ .checkmark:after {
      display: block;
    }
    
    /* Style the indicator (dot/circle) */
    .checkmark:after {
      top: 6px;
      left: 6px;
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: white;
    }
</style>
@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card mb-4">
            @foreach($employees as $employee => $value)
                @php
                    $date = App\Model\ManagerRate::where('manager_id',$value->id)
                                                 ->where('employee_id',Auth::guard('staff')->user()->id)->orderBy('created_at','desc')->first();
                    if($date == NULL) {
                        $date_mY = NULL;

                        $rate = App\Model\ManagerRate::where('manager_id',$value->id)
                                                     ->where('date', 'like', '%'.$date_mY)
                                                     ->orderBy('created_at','desc')->first();
                    
                        $dateNow = strtr($dateNow,'/','-');           
                        $date_dN = date('d',strtotime($dateNow));
                        $date_mN = date('m',strtotime($dateNow));
                        $date_yN = date('Y',strtotime($dateNow));
                        $date_mYN = $date_mN.'/'.$date_yN;
                        
                        $rateNow = App\Model\ManagerRate::where('manager_id',$value->id)
                                                        ->where('date', 'like', '%'.$date_mYN)
                                                        ->count();
                    }
                        
                    else {
                        $date = strtr($date->date,'/','-');
                        $date_d = date('d',strtotime($date));
                        $date_m = date('m',strtotime($date));
                        $date_y = date('Y',strtotime($date));
                        $date_mY = $date_m.'/'.$date_y;

                        $rate = App\Model\ManagerRate::where('manager_id',$value->id)
                                               ->where('date', 'like', '%'.$date_mY)
                                               ->orderBy('created_at','desc')->first();

                        $dateNow = strtr($dateNow,'/','-');           
                        $date_dN = date('d',strtotime($dateNow));
                        $date_mN = date('m',strtotime($dateNow));
                        $date_yN = date('Y',strtotime($dateNow));
                        $date_mYN = $date_mN.'/'.$date_yN;
                        
                        $rateNow = App\Model\ManagerRate::where('manager_id',$value->id)
                                                  ->where('date', 'like', '%'.$date_mYN)
                                                  ->count();
                    }
                @endphp
            @endforeach
        @php
            if($date == "01") $date = "มกราคม"; if($date == "07") $date = "กรกฎาคม";
            if($date == "02") $date = "กุมภาพันธ์"; if($date == "08") $date = "สิงหาคม";
            if($date == "03") $date = "มีนาคม"; if($date == "09") $date = "กันยายน";
            if($date == "04") $date = "เมษายน"; if($date == "10") $date = "ตุลาคม";
            if($date == "05") $date = "พฤษภาคม"; if($date == "11") $date = "พฤศจิกายน";
            if($date == "06") $date = "มิถุนายน"; if($date == "12") $date = "ธันวาคม";
        @endphp
        <div class="card-body" style="text-align: center;">
            <h3>แบบประเมินผู้จัดการ</h3>
            <h4>เพื่อปรับปรุงคุณภาพการทำงาน ประจำเดือน {{$date}}</h4>
            <h4>(คะแนนเต็ม 100 คะแนน)</h4>
            @foreach($employees as $employee => $value)
                <h4>{{$value->name}} {{$value->surname}} ({{$value->nickname}})</h4>
            @endforeach
            <h4 style="color:red;">** การประเมินนี้ ผู้จัดการไม่สามารถดูการประเมินในส่วนนี้ได้ จะดูได้เฉพาะทีมผู้บริหารเท่านั้น</h4>
            <hr class="my-0" />
            <div class="row">
                <div class="col-md-12">
                    <form action="{{url('/staff/from-manager-evaluate')}}" method="POST" enctype="multipart/form-data">@csrf
                        @foreach($employees as $employee => $value)
                            <input type="hidden" name="manager_id" value="{{$value->id}}">
                        @endforeach
                            <input type="hidden" name="employee_id" value="{{Auth::guard('staff')->user()->id}}">
                        <div class="card-body table-responsive text-nowrap">
                            <table class="table table-responsive table-bordered table-hover">
                                <thead>
                                    <tr style="text-align:center;">
                                        <th>รายการประเมิน</th>
                                        <th>ดีมาก</th>
                                        <th>ดี</th>
                                        <th>ปานกลาง</th>
                                        <th>น้อย</th>
                                        <th>ปรับปรุง</th>
                                    </tr>
                                </thead>
                                @foreach($evaluations as $evaluation => $value)
                                <tbody>
                                    <tr>
                                        @php
                                            $score = ($value->score)/5;
                                            $score1 = ($value->score) - 0;
                                            $score2 = $score1 - $score;
                                            $score3 = $score2 - $score;
                                            $score4 = $score3 - $score;
                                            $score5 = $score4 - $score;
                                        @endphp
                                        <td>{{$value->number}}) {{$value->list}}</td>
                                        <td>
                                            <label class="containerRadio" >
                                                <input type="radio" name="list[{{$value->id}}]" value="{{$score1}}">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="containerRadio">
                                                <input type="radio" name="list[{{$value->id}}]" value="{{$score2}}">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="containerRadio">
                                                <input type="radio" name="list[{{$value->id}}]" value="{{$score3}}"> 
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="containerRadio">
                                                <input type="radio" name="list[{{$value->id}}]" value="{{$score4}}">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <label class="containerRadio">
                                                <input type="radio" name="list[{{$value->id}}]" value="{{$score5}}">
                                                <span class="checkmark"></span>
                                            </label>
                                        </td>
                                    </tr>
                            </tbody>
                            @endforeach
                            </table>
                            <br>
                            <button class="btn btn-info" style="font-family:Sarabun; padding-right:10px; padding-left:10px;">ส่งแบบประเมิน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
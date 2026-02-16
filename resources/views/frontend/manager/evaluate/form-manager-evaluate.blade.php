@extends('frontend/layouts/employee/template')
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
    .containerRadio:hover input~.checkmark {
        background-color: #ccc;
    }

    /* When the radio button is checked, add a blue background */
    .containerRadio input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .containerRadio input:checked~.checkmark:after {
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
@section('content')
    @php
        $thai_months = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม',
        ];

        $month_num = date('n');

        $current_month = $thai_months[$month_num];
    @endphp
    <div class="container-xxl container-p-y">
        <div class="card mb-4">
            <div class="card-body" style="text-align: center;">
                <h3>แบบประเมินผู้จัดการ</h3>
                <h4>เพื่อปรับปรุงคุณภาพการทำงาน ประจำเดือน {{ $current_month }}</h4>
                <h4>(คะแนนเต็ม 100 คะแนน)</h4>
                @foreach ($employees as $employee => $value)
                    <h4>{{ $value->name }} {{ $value->surname }} ({{ $value->nickname }})</h4>
                @endforeach
                <h4 style="color:red;">** การประเมินนี้ ผู้จัดการไม่สามารถดูการประเมินในส่วนนี้ได้
                    จะดูได้เฉพาะทีมผู้บริหารเท่านั้น</h4>
                <hr class="my-0" />
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ url('/staff/from-manager-evaluate') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @foreach ($employees as $employee => $value)
                                <input type="hidden" name="manager_id" value="{{ $value->id }}">
                            @endforeach
                            <input type="hidden" name="employee_id" value="{{ Auth::guard('staff')->user()->id }}">
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
                                    @foreach ($evaluations as $evaluation => $value)
                                        <tbody>
                                            <tr>
                                                @php
                                                    $score = $value->score / 5;
                                                    $score1 = $value->score - 0;
                                                    $score2 = $score1 - $score;
                                                    $score3 = $score2 - $score;
                                                    $score4 = $score3 - $score;
                                                    $score5 = $score4 - $score;
                                                @endphp
                                                <td>{{ $value->number }}) {{ $value->list }}</td>
                                                <td>
                                                    <label class="containerRadio">
                                                        <input type="radio" name="list[{{ $value->id }}]"
                                                            value="{{ $score1 }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="containerRadio">
                                                        <input type="radio" name="list[{{ $value->id }}]"
                                                            value="{{ $score2 }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="containerRadio">
                                                        <input type="radio" name="list[{{ $value->id }}]"
                                                            value="{{ $score3 }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="containerRadio">
                                                        <input type="radio" name="list[{{ $value->id }}]"
                                                            value="{{ $score4 }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                                <td>
                                                    <label class="containerRadio">
                                                        <input type="radio" name="list[{{ $value->id }}]"
                                                            value="{{ $score5 }}">
                                                        <span class="checkmark"></span>
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                </table>
                                <br>
                                <textarea name="comment" cols="10" rows="5" class="form-control" placeholder="ความคิดเห็นเพิ่มเติม"></textarea><br><br>
                                <button class="btn btn-info"
                                    style="font-family:Sarabun; padding-right:10px; padding-left:10px;">ส่งแบบประเมิน</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

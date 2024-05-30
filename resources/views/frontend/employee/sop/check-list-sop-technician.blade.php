@extends('frontend/layouts/employee/template')
<style>
    .table> :not(caption)>*>* {
        padding: 0.3rem 1.25rem !important;
        font-size: small;
    }
</style>
@section('content')
    @php
        $date = Carbon\Carbon::now()->format('d/m/Y H:i');
        $time = Carbon\Carbon::now()->format('H:i');
    @endphp
    @if ($time > "08:00" && $time < "08:45")
        <div class="container-xxl flex-grow-1 container-p-y">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if (Session::has('alert-' . $msg))
                    <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
                @endif
            @endforeach
            <div class="card mb-4">
                <form action="{{ url('/staff/from-checklist-sop-technician') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h5 class="card-header text-center">CHECKLIST SOP ช่วงเช้า 08:00 - 08:45 น.</h5>
                        <hr>
                        @foreach ($titles as $title => $value)
                            @php
                                $checklists = DB::table('list_sops')
                                    ->where('title_id', $value->title_id)
                                    ->where('period', 'ช่วงเช้า 08.00-08.45')
                                    ->where('position', 'หัวหน้าช่าง')
                                    ->get();
                                $title = DB::table('title_sops')
                                    ->where('id', $value->title_id)
                                    ->value('title');
                            @endphp
                            @if (count($checklists) != 0)
                                <h6><strong>{{ $title }}</strong></h6>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>list</th>
                                                <th>check</th>
                                            </tr>
                                        </thead>
                                        @foreach ($checklists as $checklist => $value)
                                            <tbody class="table-border-bottom-0">
                                                <tr>
                                                    <td>{{ $value->number }}</td>
                                                    <td>{{ $value->list }}</td>
                                                    <td><input name="checklist" type="checkbox" required/></td>
                                                </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                </div><br>
                            @endif
                        @endforeach
                        <input type="hidden" name="employee_id" value="{{ Auth::guard('staff')->id() }}">
                        <input type="hidden" name="branch_id" value="{{ Auth::guard('staff')->user()->branch_id }}">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="period" value="ช่วงเช้า 08.00-08.45">
                        <input type="hidden" name="position" value="หัวหน้าช่าง">
                        <input type="hidden" name="set" value="set 1">
                        <center><button class="btn btn-info mt-3" style="font-family:Sarabun; ">บันทึกข้อมูล</button>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    @elseif($time > "18:30" && $time < "19:30")
        <div class="container-xxl flex-grow-1 container-p-y">
            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                @if (Session::has('alert-' . $msg))
                    <div class="alert alert-{{ $msg }}" role="alert">{{ Session::get('alert-' . $msg) }}</div>
                @endif
            @endforeach
            <div class="card mb-4">
                <form action="{{ url('/staff/from-checklist-sop-technician') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <h5 class="card-header text-center">CHECKLIST SOP ช่วงเย็น 18:30 - 19:30 น.</h5>
                        <hr>
                        @foreach ($titles as $title => $value)
                            @php
                                $checklists = DB::table('list_sops')
                                    ->where('title_id', $value->title_id)
                                    ->where('period', 'ช่วงเย็น 18.30-19.30')
                                    ->where('position', 'หัวหน้าช่าง')
                                    ->get();
                                $title = DB::table('title_sops')
                                    ->where('id', $value->title_id)
                                    ->value('title');
                            @endphp
                            @if (count($checklists) != 0)
                                <h6><strong>{{ $title }}</strong></h6>
                                <div class="table-responsive text-nowrap">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>list</th>
                                                <th>check</th>
                                            </tr>
                                        </thead>
                                        @foreach ($checklists as $checklist => $value)
                                            <tbody class="table-border-bottom-0">
                                                <tr>
                                                    <td>{{ $value->number }}</td>
                                                    <td>{{ $value->list }}</td>
                                                    <td><input name="checklist" type="checkbox" required/>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        @endforeach
                                    </table>
                                </div><br>
                            @endif
                        @endforeach

                        <input type="hidden" name="employee_id" value="{{ Auth::guard('staff')->id() }}">
                        <input type="hidden" name="branch_id" value="{{ Auth::guard('staff')->user()->branch_id }}">
                        <input type="hidden" name="date" value="{{ $date }}">
                        <input type="hidden" name="period" value="ช่วงเย็น 18.30-19.30">
                        <input type="hidden" name="position" value="หัวหน้าช่าง">
                        <input type="hidden" name="set" value="set 1">
                        <center><button class="btn btn-info mt-3" style="font-family:Sarabun; ">บันทึกข้อมูล</button>
                        </center>
                    </div>
                </form>
            </div>
        </div>
    @else
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-header text-center">สามารถเข้าทำ CHECKLIST SOP ได้ในช่วงเช้าเวลา 08:00 - 08:45 น.
                        และช่วงเย็นเวลา 18:30 - 19:30 น.</h5>
                </div>
            </div>
        </div>
    @endif
@endsection

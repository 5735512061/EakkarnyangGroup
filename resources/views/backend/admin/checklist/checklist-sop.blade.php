@extends('backend/layouts/admin/template')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-4">
            <div class="card-body" style="text-align: center;">
                <h3>ผลการประเมินพนักงาน</h3>
                <hr class="my-0" />
                <div class="accordion">
                    <div class="row">
                        @foreach ($years as $year => $value)
                            <div class="col-md-3 mt-3">
                                <a href="{{ url('/admin/evaluate-detail') }}/{{ $id }}/{{ $value->year }}"
                                    class="btn btn-success">ผลการตรวจเช็ค SOP ปี {{ $value->year }}</a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--  --}}

    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">SOP /</span> ผลการตรวจเช็ค SOP</h4>
        {{ $checklists->links() }}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ผู้ทำ Checklist</th>
                                    <th>ตำแหน่ง</th>
                                    <th>สาขา</th>
                                    <th>วันที่ทำ checklist</th>
                                    <th>หัวข้อ</th>
                                    <th>สถานะ</th>
                                </tr>
                            </thead>
                            @foreach ($checklists as $checklist => $value)
                                @php
                                    $name = DB::table('employees')
                                        ->where('id', $value->employee_id)
                                        ->value('name');
                                    $surname = DB::table('employees')
                                        ->where('id', $value->employee_id)
                                        ->value('surname');
                                    $nickname = DB::table('employees')
                                        ->where('id', $value->employee_id)
                                        ->value('nickname');
                                    $position_id = DB::table('employees')
                                        ->where('id', $value->employee_id)
                                        ->value('position_id');
                                    $position = DB::table('positions')->where('id', $position_id)->value('position');
                                    $branch_id = DB::table('employees')
                                        ->where('id', $value->employee_id)
                                        ->value('branch_id');
                                    $branch = DB::table('branch_groups')->where('id', $branch_id)->value('branch');
                                @endphp
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>{{ $NUM_PAGE * ($page - 1) + $checklist + 1 }}</td>
                                        <td>{{ $name }} {{ $surname }} ({{ $nickname }})</td>
                                        <td>{{ $position }}</td>
                                        <td>{{ $branch }}</td>
                                        <td>{{ $value->date }}</td>
                                        <td>{{ $value->set }} {{ $value->period }}</td>
                                        <td>{{ $value->status }}</td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

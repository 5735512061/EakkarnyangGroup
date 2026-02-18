@extends('backend/layouts/admin/template-without-menu')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h3 class="fw-bold py-3 mb-4 text-center"><span class="fw-light">พนักงานดีเด่นประจำเดือน</span></h3>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ url('admin/create-best-employee') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                @if (Session::has('alert-' . $msg))
                                    <div class="alert alert-{{ $msg }}" role="alert">
                                        {{ Session::get('alert-' . $msg) }}</div>
                                @endif
                            @endforeach
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label>ประจำปี : </label>
                                    <select class="form-control" name="year">
                                        <option value="2569">ปี 2569</option>
                                        <option value="2570">ปี 2570</option>
                                        <option value="2571">ปี 2571</option>
                                        <option value="2572">ปี 2572</option>
                                        <option value="2573">ปี 2573</option>
                                        <option value="2574">ปี 2574</option>
                                        <option value="2575">ปี 2575</option>
                                        <option value="2576">ปี 2576</option>
                                        <option value="2577">ปี 2577</option>
                                        <option value="2578">ปี 2578</option>
                                        <option value="2579">ปี 2579</option>
                                        <option value="2580">ปี 2580</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>ประจำเดือน : </label>
                                    <select class="form-control" name="month">
                                        <option value="มกราคม">เดือน มกราคม</option>
                                        <option value="กุมภาพันธ์">เดือน กุมภาพันธ์</option>
                                        <option value="มีนาคม">เดือน มีนาคม</option>
                                        <option value="เมษายน">เดือน เมษายน</option>
                                        <option value="พฤษภาคม">เดือน พฤษภาคม</option>
                                        <option value="มิถุนายน">เดือน มิถุนายน</option>
                                        <option value="กรกฎาคม">เดือน กรกฎาคม</option>
                                        <option value="สิงหาคม">เดือน สิงหาคม</option>
                                        <option value="กันยายน">เดือน กันยายน</option>
                                        <option value="ตุลาคม">เดือน ตุลาคม</option>
                                        <option value="พฤศจิกายน">เดือน พฤศจิกายน</option>
                                        <option value="ธันวาคม">เดือน ธันวาคม</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>เลือกชื่อพนักงาน : </label>

                                    <select name="employee_id" id="employee_select" class="form-control" required>
                                        <option value="">-- พิมพ์เพื่อค้นหา --</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}
                                                {{ $employee->surname }} ({{ $employee->nickname }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label>ไฟล์รูปภาพ : </label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-success me-2"
                                    style="font-family: 'Sarabun';">อัพโหลดพนักงานดีเด่น</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h4>รายชื่อพนักงานดีเด่น</h4>
                            <div class="table-responsive text-nowrap">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>รูปภาพ</th>
                                            <th>ประจำเดือน</th>
                                            <th>ชื่อ-นามสกุล</th>
                                            <th>สาขา</th>
                                        </tr>
                                    </thead>
                                    @foreach ($best_employees as $best_employee => $value)
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
                                            $branch_id = DB::table('employees')
                                                ->where('id', $value->employee_id)
                                                ->value('branch_id');
                                            $branch = DB::table('branch_groups')
                                                ->where('id', $branch_id)
                                                ->value('branch');
                                        @endphp
                                        <tbody class="table-border-bottom-0">
                                            <tr>
                                                <td>{{ $NUM_PAGE * ($page - 1) + $best_employee + 1 }}</td>
                                                <td width="10%"><img
                                                        src="{{ url('img_upload/best-employee') }}/{{ $value->image }}"
                                                        alt="profile" width="100%" /></td>
                                                <td>{{ $value->month }} {{ $value->year }}</td>
                                                <td>{{ $name }} {{ $surname }} ({{ $nickname }})</td>
                                                <td>{{ $branch }}</td>
                                            </tr>
                                        </tbody>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#employee_select').select2({
                theme: 'bootstrap-5',
                width: '100%',
                placeholder: "-- พิมพ์เพื่อค้นหา --",
                allowClear: true,
                selectionCssClass: 'select2--small', // (Option) ถ้าต้องการขนาดเล็กลง
                dropdownCssClass: 'select2--small',
            });
        });
    </script>
@endsection

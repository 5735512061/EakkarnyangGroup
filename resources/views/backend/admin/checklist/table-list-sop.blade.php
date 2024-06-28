@extends('backend/layouts/admin/template')
<style>
    .table> :not(caption)>*>* {
        padding: 0.3rem 1.25rem !important;
        font-size: small;
    }
</style>
@section('content')
    <center>
        <h3 class="mt-5">CHECKLIST SOP สำหรับผู้จัดการ ตัวแทนผู้จัดการ</h3>
    </center>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header text-center">CHECKLIST SOP ช่วงเช้า 08:00 - 08:45 น. (สำหรับผู้จัดการ ตัวแทนผู้จัดการ)
                </h5>
                <hr>
                @foreach ($titles as $title => $value)
                    @php
                        $checklists = DB::table('list_sops')
                            ->where('title_id', $value->title_id)
                            ->where('period', 'ช่วงเช้า 08.00-08.45')
                            ->where('position', 'ผู้จัดการ')
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
                                    </tr>
                                </thead>
                                @foreach ($checklists as $checklist => $value)
                                    <tbody class="table-border-bottom-0">
                                        <tr>
                                            <td>{{ $value->number }}</td>
                                            <td>{{ $value->list }}</td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div><br>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header text-center">CHECKLIST SOP ช่วงเย็น 18:30 - 19:30 น. (สำหรับผู้จัดการ ตัวแทนผู้จัดการ)
                </h5>
                <hr>
                @foreach ($titles as $title => $value)
                    @php
                        $checklists = DB::table('list_sops')
                            ->where('title_id', $value->title_id)
                            ->where('period', 'ช่วงเย็น 18.30-19.30')
                            ->where('position', 'ผู้จัดการ')
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
                                    </tr>
                                </thead>
                                @foreach ($checklists as $checklist => $value)
                                    <tbody class="table-border-bottom-0">
                                        <tr>
                                            <td>{{ $value->number }}</td>
                                            <td>{{ $value->list }}</td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div><br>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <center>
        <h3 class="mt-5">CHECKLIST SOP สำหรับหัวหน้าช่าง ตัวแทนหัวหน้าช่าง</h3>
    </center>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header text-center">CHECKLIST SOP ช่วงเช้า 08:00 - 08:45 น. (สำหรับหัวหน้าช่าง
                    ตัวแทนหัวหน้าช่าง)
                </h5>
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
                                    </tr>
                                </thead>
                                @foreach ($checklists as $checklist => $value)
                                    <tbody class="table-border-bottom-0">
                                        <tr>
                                            <td>{{ $value->number }}</td>
                                            <td>{{ $value->list }}</td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div><br>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-body">
                <h5 class="card-header text-center">CHECKLIST SOP ช่วงค่ำ 18:30 - 19:30 น. (สำหรับหัวหน้าเชฟ รองหัวหน้าเชฟ)
                </h5>
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
                                    </tr>
                                </thead>
                                @foreach ($checklists as $checklist => $value)
                                    <tbody class="table-border-bottom-0">
                                        <tr>
                                            <td>{{ $value->number }}</td>
                                            <td>{{ $value->list }}</td>
                                        </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div><br>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection

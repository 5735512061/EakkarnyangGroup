@extends('frontend/layouts/employee/template')

@section('content')
    <div class="container-xxl container-p-y">
        <div class="row">
            <div class="col-md-12">
                <!-- Hoverable Table rows -->
                <div class="card">
                    <h5 class="card-header">ข้อมูลผู้จัดการ</h5>
                    <div class="table-responsive text-nowrap">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>ชื่อเล่น</th>
                                    <th>สาขา</th>
                                    <th>ประเมินพนักงาน</th>
                                </tr>
                            </thead>
                            @foreach ($managers as $manager => $value)

                                @php
                                    $branch = DB::table('branch_groups')
                                        ->where('id', $value->branch_id)
                                        ->value('branch');
                                @endphp
                                <tbody class="table-border-bottom-0">
                                    <tr>
                                        <td>{{ $value->name }} {{ $value->surname }}</td>
                                        <td>{{ $value->nickname }}</td>
                                        <td>{{ $branch }}</td>
                                        @php

                                            //วันสุดท้ายของไตรมาส
                                            // $last_of_quarter = now();
                                            // $last_of_quarter->lastOfQuarter();

                                            $date = App\Model\ManagerRate::where('manager_id', $value->id)
                                                ->orderBy('created_at', 'desc')
                                                ->first();
                                                

                                            if ($date == null) {
                                                $date_mY = null;

                                                $dateNow = strtr($dateNow, '/', '-');
                                                $date_dN = date('d', strtotime($dateNow));
                                                $date_mN = date('m', strtotime($dateNow));
                                                $date_yN = date('Y', strtotime($dateNow));
                                                $date_mYN = $date_mN . '/' . $date_yN;
                                            } else {
                                                $date = strtr($date->date, '/', '-');
                                                $date_d = date('d', strtotime($date));
                                                $date_m = date('m', strtotime($date));
                                                $date_y = date('Y', strtotime($date));
                                                $date_mY = $date_m . '/' . $date_y;

                                                $dateNow = strtr($dateNow, '/', '-');
                                                $date_dN = date('d', strtotime($dateNow));
                                                $date_mN = date('m', strtotime($dateNow));
                                                $date_yN = date('Y', strtotime($dateNow));
                                                $date_mYN = $date_mN . '/' . $date_yN;
                                            }
                                        @endphp
                                        @if ($date_mY === $date_mYN)
                                            <td>
                                                <a class="btn btn-success text-white">
                                                    <i class="fa fa-check"></i> ประเมินเรียบร้อย
                                                </a>
                                            </td>
                                        @elseif($date_mY !== $date_mYN)
                                            <td>
                                                <a class="btn btn-danger text-white" style="color:#525F7F;"
                                                    href="{{ url('/staff/form-manager-evaluate/') }}/{{ $value->id }}">
                                                    <i class="ni ni-chart-bar-32 text-primary"></i> ประเมินผู้จัดการ
                                                </a>
                                            </td>
                                        @elseif($date_mY == null || $date_mYN == null)
                                            <td>
                                                <a class="btn btn-danger text-white" style="color:#525F7F;"
                                                    href="{{ url('/staff/form-manager-evaluate/') }}/{{ $value->id }}">
                                                    <i class="ni ni-chart-bar-32 text-primary"></i> ประเมินผู้จัดการ
                                                </a>
                                            </td>
                                        @endif
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
                <!--/ Hoverable Table rows -->
            </div>
        </div>
    </div>
@endsection

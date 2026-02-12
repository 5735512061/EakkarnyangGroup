@extends('backend/layouts/admin/template-without-menu')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">สวัสดิการพนักงาน /</span> บริษัท เอกการยางออโต้เซอร์วิส
            จำกัด</h4>
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ url('admin/create-benefit-staff') }}" method="POST"
                            enctype="multipart/form-data">@csrf
                            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                @if (Session::has('alert-' . $msg))
                                    <div class="alert alert-{{ $msg }}" role="alert">
                                        {{ Session::get('alert-' . $msg) }}</div>
                                @endif
                            @endforeach
                            <div class="row">
                                <div class="mb-3 col-md-12">
                                    <label>ชื่อร้าน : </label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label>รายละเอียดสวัสดิการ : </label>
                                    <input type="text" name="detail" class="form-control">
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label>ไฟล์รูปภาพ : </label>
                                    <input type="file" name="image" class="form-control">
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label>สถานะ : </label>
                                    <select class="form-control">
                                        <option value="เปิดใช้งาน">เปิดใช้งาน</option>
                                        <option value="ปิดการใช้งาน">ปิดการใช้งาน</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-success me-2"
                                    style="font-family: 'Sarabun';">อัพโหลดสวัสดิการพนักงาน</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

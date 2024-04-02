@extends('backend/layouts/admin/template-without-menu')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">กฎระเบียบบริษัท /</span> บริษัท เอกการยางออโต้เซอร์วิส
            จำกัด</h4>
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">อัพโหลดไฟล์กฎระเบียบบริษัท <span style="color: red;">** (รองรับเฉพาะไฟล์ PDF เท่านั้น)</span></h5>
                    <div class="card-body">
                        <form action="{{ url('admin/create-company-regulations') }}" method="POST"
                            enctype="multipart/form-data">@csrf
                            @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                                @if (Session::has('alert-' . $msg))
                                    <div class="alert alert-{{ $msg }}" role="alert">
                                        {{ Session::get('alert-' . $msg) }}</div>
                                @endif
                            @endforeach
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    @if ($errors->has('file_company_regulations'))
                                        <strong style="color: red;">( {{ $errors->first('file_company_regulations') }}
                                            )</strong>
                                    @endif
                                    <input class="form-control" type="file" name="file_company_regulations" autofocus />
                                </div>
                            </div>
                            @php
                                $date = Carbon\Carbon::now();
                            @endphp
                            <div class="mt-2">
                                <input type="hidden" name="date" value="{{ $date }}">
                                <button type="submit" class="btn btn-success me-2"
                                    style="font-family: 'Sarabun';">อัพโหลดไฟล์กฎระเบียบบริษัท</button>
                                <button type="reset" class="btn btn-outline-secondary"
                                    style="font-family: 'Sarabun';">ยกเลิก</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th></th>
                        </tr>
                      </thead>
                      <tbody class="table-border-bottom-0">
                        @foreach ($file_regulations as $file_regulation => $value)
                        <tr>
                          <td>{{$NUM_PAGE*($page-1) + $file_regulation+1}}</td>
                          <td>ไฟล์กฎระเบียบบริษัท {{$value->date}}</td>
                          <td>
                            <a href="{{ url('/admin/preview-file-company-regulations') }}/{{ $value->id }}" class="btn btn-success">Preview</a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
        </div>
    </div>
@endsection

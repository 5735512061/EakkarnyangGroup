@extends("backend/layouts/admin/template") 

@section("content")
<div class="container-xxl flex-grow-1 container-p-y">
  <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">จัดการข้อมูลพนักงาน /</span> การใช้งานเว็บไซต์ E-learning</h4>
    <div class="row">
      @php
          $branch = DB::table('branch_groups')->where('id',$branch_id)->value('branch');
      @endphp
      <div class="col-md-12">
        <!-- Hoverable Table rows -->
        <div class="card">
          <h5 class="card-header">การใช้งานเว็บไซต์ E-learning {{$branch}}</h5>
          <div class="table-responsive text-nowrap">
            <table class="table table-hover">
              <thead>
                <tr>
                    <th>#</th>
                    <th>รายชื่อ</th>
                    <th>วันที่</th>
                    <th>จำนวนการเข้าใช้</th>
                </tr>
              </thead>
              @foreach($statistics as $statistic => $value)
                @php
                    $name = DB::table('employees')->where('id',$value->staff_id)->value('name');
                    $surname = DB::table('employees')->where('id',$value->staff_id)->value('surname');
                @endphp
              <tbody class="table-border-bottom-0">
                <tr>
                    <td>{{$NUM_PAGE*($page-1) + $statistic+1}}</td>
                    <td>{{$name}} {{$surname}}</td>
                    <td>{{$value->date}}</td>
                    <td>{{$value->count}}</td>
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
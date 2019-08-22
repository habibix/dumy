<!-- LAYOUT -->
@extends('layouts.app')

<!-- NAVBAR SECTION -->
@section('navbar')
	@include('page.admin.nav')
@endsection

<!-- CONTENT SECTION -->
@section('content')

<div class="col-md-12">

@if (session('success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {!! session('success') !!}</h4>
    </div>
@endif

</div>

<div class="col-md-6">
  <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Logs User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-body">
                <div class="table-responsive">
          <table id="dataTable" class="table table-hover">
              <thead>
                  <tr>
                      <td>#</td>
                      <td>User</td>
                      <td>Activiry</td>
                      <td>Time</td>
                      <td></td>
                  </tr>
              </thead>
              <tbody>
                  @php $no = 1; @endphp
                  @forelse ($logs as $row)
                  <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $row->user_id }}</td>
                      <td>{{ $row->activity }}</td>
                      <td>{{ $row->created_at }}</td>
                  </tr>
                  @empty
                  <tr>
                      <td colspan="5" class="text-center">Tidak ada data</td>
                  </tr>
                  @endforelse
              </tbody>
          </table>
      </div>
</div>
              </div>
              <!-- /.box-body -->

          </div>
      
</div>
@endsection


<!-- HEADER SECTION -->
@section('header')

@endsection

<!-- FOOTER SECTION -->
@section('footer')
<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
  $(function () {
    $('#dataTable').DataTable()
  })
</script>
@endsection
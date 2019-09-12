<!-- LAYOUT -->
@extends('layouts.app')

<!-- NAVBAR SECTION -->
@section('navbar')
	@include('page.operator.nav')
@endsection

<!-- CONTENT SECTION -->
@section('content')
<!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-lg-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Kendaraan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>No.</th>
                  <th>Anomali</th>
                  <th>Camera</th>
                  <th>Capture Foto</th>
                  <th>Capture Video</th>
                  <th>LPR</th>
                </tr>
                </thead>
                <tbody>
                @php $no = 1; @endphp
                @foreach ($anomali as $row)
                  <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $row->anomali }}</td>
                    <td>{{ $row->camera['lokasi'] }}</td>
                    <td><a href="#">{{ $row->image }}</a></td>
                    <td><a href="#">{{ $row->video }}</a></td>
                    <td>unread</td>
                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>No.</th>
                  <th>Anomali</th>
                  <th>Camera</th>
                  <th>Capture Foto</th>
                  <th>Capture Video</th>
                  <th>LPR</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>
      </div>

      <div class="row" style="margin-top: 20px">
        <div class="col-xs-12">
          <!-- data-chart -->
          
        </div>

      </div>

    </section>
    <!-- /.content -->
@endsection


<!-- HEADER SECTION -->
@section('header')

<style type="text/css">
#map {
min-width: 320px;
min-height: 400px;
height: 600px;
margin: auto;
padding: 10px 10px 0 10px;
}
</style>

<script src="sdk/js/form.js"></script>
<script src="sdk/tomtom.min.js"></script>
@endsection

<!-- FOOTER SECTION -->
@section('footer')
<!-- highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

<script>
  $(function () {
    $('#example1').DataTable({
      pageLength : 6
    })
  })
</script>
@endsection
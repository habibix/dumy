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
    <h3 class="box-title">Add User</h3>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <form action="{{ route('addUser') }}" method="post">
  {{ csrf_field() }}
  <div class="box-body">
  <div class="form-group">
      <label for="">Nama</label>
      <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" required>
      <p class="text-danger">{{ $errors->first('name') }}</p>
  </div>
  <div class="form-group">
      <label for="">Email</label>
      <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" required>
      <p class="text-danger">{{ $errors->first('email') }}</p>
  </div>
  <div class="form-group">
      <label for="">Password</label>
      <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" required>
      <p class="text-danger">{{ $errors->first('password') }}</p>
  </div>
  <div class="form-group">
      <label for="">Role</label>
      <select name="role" class="form-control {{ $errors->has('role') ? 'is-invalid':'' }}" required>
          <option value="">Pilih</option>
          <option value="operator">Operator</option>
          <option value="admin">Admin</option>
      </select>
      <p class="text-danger">{{ $errors->first('role') }}</p>
  </div>
  <div class="form-group">
      <button class="btn btn-primary btn-sm">
          <i class="fa fa-send"></i> Simpan
      </button>
  </div>
</div>
</form>
</div>

</div>

<div class="col-md-6">
  <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">List User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

              <div class="box-body">
                <div class="table-responsive">
          <table class="table table-hover">
              <thead>
                  <tr>
                      <td>#</td>
                      <td>Name</td>
                      <td>Email</td>
                      <td>Role</td>
                      <td>Created At</td>
                      <td></td>
                  </tr>
              </thead>
              <tbody>
                  @php $no = 1; @endphp
                  @forelse ($user as $row)
                  <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $row->name }}</td>
                      <td>{{ $row->email }}</td>
                      <td>{{ $row->type }}</td>
                      <td>{{ $row->created_at }}</td>
                      <td>
                          <form action="{{ route('deleteUser', $row->id) }}" method="GET">
                              {{ csrf_field() }}
                              <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                          </form>
                      </td>
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
              <!-- /.box-body -->

          </div>
      
</div>
</div>
@endsection


<!-- HEADER SECTION -->
@section('header')
<script src="http://www.fasyasolusindo.com/tmaps/sdk/js/form.js"></script>
<script type='text/javascript' src='https://cdn.rawgit.com/jasonmoo/t.js/master/t.min.js'></script>
<script src="http://www.fasyasolusindo.com/tmaps/sdk/sdk/tomtom.min.js"></script>

<style type="text/css">
#example-map {
min-width: 320px;
min-height: 400px;
height: 400px;
margin: auto;
padding: 10px 10px 0 10px;
}
</style>
@endsection

<!-- FOOTER SECTION -->
@section('footer')
<!-- highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="http://www.fasyasolusindo.com/tmaps/sdk/sdk/tomtom.min.js"></script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

<script type="text/javascript">
Highcharts.chart('container-chart', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Weekly Average Counting'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: ['week 1', 'week 2', 'week 3', 'week 4', 'week 5', 'week 6', 'week 7', 'week 8']
    },
    yAxis: {
        title: {
            text: 'Jumlah Kendaraan'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Camera 1',
        data: [{{ count($countWeek) }}]
    }, {
        name: 'Camera 2',
        data: [3568]
    }]
});
</script>

<script type="text/javascript">
tomtom.setProductInfo('<your-product-name>', '<your-product-version>');
var markerOptions = {
    icon: tomtom.L.icon({
        iconUrl: 'https://api.tomtom.com/maps-sdk-js/4.47.6/examples/img/icon.png',
        iconSize: [30, 34],
        iconAnchor: [15, 34]
    })
};
var map = tomtom.map('example-map', {
    key: 'ViASnrhbgAvEijHSeUJD3DNJbSeC3dfO',
    source: 'raster',
    basePath: '<your-tomtom-sdk-base-path>'
});
tomtom.L.marker([-6.213764, 106.806968], markerOptions).addTo(map);
tomtom.L.marker([-6.196751, 106.897190], markerOptions).addTo(map);
tomtom.L.marker([-6.263300, 106.872464], markerOptions).addTo(map);
tomtom.L.marker([-6.148313, 106.791688], markerOptions).addTo(map);
map.setView([-6.219184, 106.846257], 10);


</script>
@endsection
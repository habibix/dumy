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
          <form>
            <div class="col-xs-2">
            <div class="form-group">
              <select class="form-control">
                <option>ATMS</option>
                <option>ATMC</option>
              </select>
            </div>
          </div>

          <div class="col-xs-2">
            <div class="form-group">
              <select class="form-control">
                <option>JPO MT Haryono</option>
                <option>JPO Harapakn Kita</option>
                <option>JPO POLDA</option>
                <option>JPO Senayan Barat</option>
                <option>JPO Telkom</option>
                <option>JPO Senayan Barat</option>
                <option>JPO Jamsostek</option>
                 <option>JPO Tebet</option>
                 <option>JPO Cikarang Timur</option>

              </select>
            </div>
          </div>

          <div class="col-xs-3">
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Filter</button>
            </div>
          </div>
          </form>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-12">

            <div class="box box-solid">
              <div class="box-header with-border">

                <h3 class="box-title">Camera Detail</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <dl class="dl-horizontal">
                  <dt>Wilayah :</dt>
                  <dd>Polda Metro</dd>

                  <dt>Area :</dt>
                  <dd>ATCS</dd>

                  <dt>Lokasi :</dt>
                  <dd>JPO MT Haryono</dd>

                  <dt>Arah :</dt>
                  <dd>Cawang menuju Grogol</dd>

                </dl>
              </div>
            <!-- /.box-body -->
            </div>

        </div>
        <div class="col-lg-6">
          <iframe src="http://192.168.100.18:5000/" width="640" height="480" scrolling="no" frameborder="0"></iframe>
        </div>
        <div class="col-lg-6">
                    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Kendaraan</h3>
              <!-- @foreach ($xAxis as $row)
                {{ $row }}
              @endforeach -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Camera</th>
                  <th>Total</th>
                  <th>Vehicle</th>
                  <th>Datetime</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($count_rekap as $row)
                  <tr>
                    <td>{{ $row->camera_id }}</td>
                    <td>{{ $row->total }}</td>
                    <td>{{ $row->vehicle }}</td>
                    <td>{{ $row->created_at->format('D, d/m/Y') }}</td>
                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Camera</th>
                  <th>Total</th>
                  <th>Vehicle</th>
                  <th>Datetime</th>
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
          {!! $chart->html() !!}
        </div>

        <div class="col-xs-12">
          <!-- /.box -->
          

          <!-- /.box -->
        </div>

      </div>

    </section>
    <!-- /.content -->
@endsection


<!-- HEADER SECTION -->
@section('header')
<link rel="stylesheet" type="text/css" href='sdk/map.css'/>
<link rel="stylesheet" type="text/css" href="sdk/elements.css">

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

{!! $chart->script() !!}

<!-- <script src='sdk/maps-web.min.js'></script>
<script src="sdk/js/form.js"></script>
<script type='text/javascript' src='https://cdn.rawgit.com/jasonmoo/t.js/master/t.min.js'></script> -->

<script type="text/javascript">
tomtom.setProductInfo('tmaps', '0.1');
var markerOptions = {
    icon: tomtom.L.icon({
        iconUrl: 'https://api.tomtom.com/maps-sdk-js/4.47.6/examples/img/icon.png',
        iconSize: [30, 34],
        iconAnchor: [15, 34]
    })
};

var addressPoints = [
    [-6.243347,106.8565551, 'ATMS 01 JPO KORLANTAS'],
    [-6.2379992,106.8327819, 'ATMS 03 JPO TEBET 2'],
    [-6.2379133,106.8327818, 'ATMS 09 JPO KUNINGAN'],
    [-6.2341636,106.8207929, 'ATMS 10 JPO MAMPANG'],
    [-6.2341529,106.8207929, 'ATMS 12 JPO JAMSOSTEK'],
    [-6.2428229,106.8310242, 'ATMS 13 JPO TELKOM'],
    [-6.242715,106.8047593, 'ATMS 14 JPO POLDA'],
    [-6.2149985,106.8070094, 'ATMS 16 JPO SENAYAN-BARAT'],
    [-6.1850632,106.7961225, 'ATMS 22 JPO HARAPAN KITA'],
    [-6.2102507,106.819901, 'ATMS 26 JPO TAMAN-ANGGREK 2']
];

var map = tomtom.map('map', {
    dragging: false,
    touchZoom: false,
    scrollWheelZoom: false,
    doubleClickZoom: false,
    boxZoom: false,
    tap: false,
    keyboard: false,
    zoomControl: false,
    key: 'ViASnrhbgAvEijHSeUJD3DNJbSeC3dfO',
    source: 'raster',
    basePath: '<your-tomtom-sdk-base-path>'
});
/*tomtom.L.marker([43.26456, -71.5702], markerOptions).addTo(map);
tomtom.L.marker([39.73845, -104.98485], markerOptions).addTo(map);
tomtom.L.marker([34.05224, -118.24334], markerOptions).addTo(map);
tomtom.L.marker([37.78008, -122.42017], markerOptions).addTo(map);*/
map.setView([-6.2106012,106.8199012], 12);

var markers = tomtom.L.markerClusterGroup();
addressPoints.forEach(function(point) {
    var title = point[2],
        marker = tomtom.L.marker(new tomtom.L.LatLng(point[0], point[1]), {title: title});
    marker.bindPopup(title);
    markers.addLayer(marker);
});
map.addLayer(markers);

</script>
@endsection
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
      </div>

      <div class="row" style="margin-top: 20px">

        <div class="col-lg-6">
          <iframe src="http://192.168.100.18:5000/" width="640" height="480" scrolling="no" frameborder="0"></iframe>
        </div>
        <div class="col-lg-6">
          <div id="speed_chart"></div>
        </div>
      </div>

      <div class="row" style="margin-top: 20px">
        <div class="col-xs-12">
          <!-- data-chart -->
          {!! $speed_chart->html() !!}
        </div>

        <div class="col-lg-12" style="margin-top: 20px"> 

          <div class="box">
            <div class="box-header text-center">
              <h3 class="box-title">Rata-Rata Kecepatan Kendaraan</h3>
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
                  <th>Speed</th>
                  <th>Datetime</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($speed as $row)
                  <tr>
                    <td>{{ $row->camera_id }}</td>
                    <td>{{ $row->speed }}</td>
                    <td>{{ $row->created_at->format('D, d/m/Y') }}</td>
                  </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Camera</th>
                  <th>Speed</th>
                  <th>Datetime</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
        </div>

    </section>
    <!-- /.content -->
@endsection


<!-- HEADER SECTION -->
@section('header')



@endsection

<!-- FOOTER SECTION -->
@section('footer')
<!-- highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

{!! $speed_chart->script() !!}

<script type="text/javascript">
  Highcharts.chart('speed_chart', {

    chart: {
        type: 'gauge',
        plotBackgroundColor: null,
        plotBackgroundImage: null,
        plotBorderWidth: 0,
        plotShadow: false
    },

    title: {
        text: 'Rata-rata Kecepatan Keseluruhan'
    },

    pane: {
        startAngle: -150,
        endAngle: 150,
        background: [{
            backgroundColor: {
                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                stops: [
                    [0, '#FFF'],
                    [1, '#333']
                ]
            },
            borderWidth: 0,
            outerRadius: '109%'
        }, {
            backgroundColor: {
                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                stops: [
                    [0, '#333'],
                    [1, '#FFF']
                ]
            },
            borderWidth: 1,
            outerRadius: '107%'
        }, {
            // default background
        }, {
            backgroundColor: '#DDD',
            borderWidth: 0,
            outerRadius: '105%',
            innerRadius: '103%'
        }]
    },

    // the value axis
    yAxis: {
        min: 0,
        max: 200,

        minorTickInterval: 'auto',
        minorTickWidth: 1,
        minorTickLength: 10,
        minorTickPosition: 'inside',
        minorTickColor: '#666',

        tickPixelInterval: 30,
        tickWidth: 2,
        tickPosition: 'inside',
        tickLength: 10,
        tickColor: '#666',
        labels: {
            step: 2,
            rotation: 'auto'
        },
        title: {
            text: 'km/h'
        },
        plotBands: [{
            from: 0,
            to: 120,
            color: '#55BF3B' // green
        }, {
            from: 120,
            to: 160,
            color: '#DDDF0D' // yellow
        }, {
            from: 160,
            to: 200,
            color: '#DF5353' // red
        }]
    },

    series: [{
        name: 'Speed',
        data: [{{ $avg_speed }}],
        tooltip: {
            valueSuffix: ' km/h'
        }
    }]

},
// Add some life
function (chart) {
    
});
</script>

<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>

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
@endsection
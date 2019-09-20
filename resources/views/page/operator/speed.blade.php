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
        <div class="col-lg-2">
          <div class="dropdown form-group">
            <a href="#" class="dropdown-toggle form-control" data-toggle="dropdown">Pilih Lokasi<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
              @foreach ($camera as $row)
                <li><a href="{{ route('operator_speed_id', $row->id) }}">{{ $row->lokasi }}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">{!! $chart->html() !!}</div>
      </div>

    </section>
    <!-- /.content -->
@endsection


<!-- HEADER SECTION -->
@section('header')

<link rel="stylesheet" href="../../apricot/dark-chart.css" />

@endsection

<!-- FOOTER SECTION -->
@section('footer')

{!! Charts::scripts() !!}

{!! $chart->script() !!}

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
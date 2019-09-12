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
        <div class="col-xs-12">
          <!-- data-chart -->
          {!! $chart->html() !!}
        </div>
      </div>

      <div class="row" style="margin-top: 20px">
        <div class="col-xs-6">
          <!-- <iframe src="http://127.0.0.1:5000/?camera=111" width="640" height="480" scrolling="no" frameborder="0"></iframe> -->
          {{ $active_camera->rtsp_address }}
        </div>
        <div class="col-xs-6">
          <div id="speed_avg"></div>
        </div>
      </div>

    </section>
    <!-- /.content -->
@endsection


<!-- HEADER SECTION -->
@section('header')

{!! Charts::styles() !!}

@endsection

<!-- FOOTER SECTION -->
@section('footer')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<script>
    $(function() {
        $('.charts').each(function() {
            var chart = $(this).find('.charts-chart');
            var loader = $(this).find('.charts-loader');
            var time = loader.data('duration');

            if(loader.hasClass('enabled')) {
                chart.css({visibility: 'hidden'});
                loader.fadeIn(350);

                setTimeout(function() {
                    loader.fadeOut(350, function() {
                        chart.css({opacity: 0, visibility: 'visible'}).animate({opacity: 1}, 350);
                    });
                }, time)
            }
        });
    })
</script>



<script type="text/javascript">
  Highcharts.chart('speed_avg', {

    chart: {
        type: 'gauge',
        plotBackgroundColor: null,
        plotBackgroundImage: null,
        plotBorderWidth: 0,
        plotShadow: false
    },

    title: {
        text: 'Speedometer'
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
    if (!chart.renderer.forExport) {
        setInterval(function () {
            var point = chart.series[0].points[0],
                newVal,
                inc = Math.round((Math.random() - 0.5) * 20);

            newVal = {{ $avg_speed }};
            if (newVal < 0 || newVal > 200) {
                newVal = {{ $avg_speed }};
            }

            point.update(newVal);

        }, 3000);
    }
});
</script>

{!! $chart->script() !!}

@endsection
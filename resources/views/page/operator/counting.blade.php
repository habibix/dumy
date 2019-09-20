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
                <li><a href="{{ route('operator_counting_id', $row->id) }}">{{ $row->lokasi }}</a></li>
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
<!-- highcharts -->
<!-- <script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script> -->

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

{!! Charts::scripts() !!}
{!! $chart->script() !!}

@endsection
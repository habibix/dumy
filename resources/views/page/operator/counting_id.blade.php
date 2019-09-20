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
                  <dd>{{ $active_camera->lokasi }}</dd>

                  <dt>Arah :</dt>
                  <dd>Cawang menuju Grogol</dd>

                </dl>
              </div>
            <!-- /.box-body -->
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
        <div class="col-lg-6">
          <iframe src="{{ config('app.url_friend') }}/?camera={{ $active_camera->id }}" width="640" height="480" scrolling="no" frameborder="0"></iframe> 
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
                    <td>{{ $row->camera->lokasi }}</td>
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


{!! $chart->script() !!}

@endsection
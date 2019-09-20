<!-- LAYOUT -->
@extends('layouts.page_app')

<!-- NAVBAR SECTION -->
@section('navbar')
@include('page.operator.page_nav')
@endsection

<!-- CONTENT -->
@section('content')

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
    <div class="col-sm-3">
        <div class="order" id="orderClose">
            <div class="headline ">
                <h3>
                    <span style="background-color: #FF6B6B">
                        <i class="maki-airport"></i>&#160;&#160;WILAYAH</span>
                </h3>
                <div class="titleClose">
                    <a href="#orderClose" class="gone">
                        <span class="entypo-cancel"></span>
                    </a>
                </div>
            </div>
            <span>
                <h3>
                    <center style="margin-top: 10px">{{ Auth::user()->name }}</center>
                </h3>
            </span>
            <div class="progress-tinny">
                <div style="width: 10%" class="bar"></div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="order" id="orderClose">
            <div class="headline ">
                <h3>
                    <span style="background-color: #FFA200;">
                        <i class="maki-airport"></i>&#160;&#160;LOKASI</span>
                </h3>
                <div class="titleClose">
                    <a href="#orderClose" class="gone">
                        <span class="entypo-cancel"></span>
                    </a>
                </div>
            </div>
            <span>
                <h3>
                    <center style="margin-top: 10px">{{ $active_camera->lokasi }}</center>
                </h3>
            </span>
            <div class="progress-tinny">
                <div style="width: 10%" class="bar"></div>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="order" id="orderClose">
            <div class="headline ">
                <h3>
                    <span>
                        <i class="maki-airport"></i>&#160;&#160;KOORDINAT</span>
                </h3>
                <div class="titleClose">
                    <a href="#orderClose" class="gone">
                        <span class="entypo-cancel"></span>
                    </a>
                </div>
            </div>
            <span>
                <h3>
                    <center style="margin-top: 10px">{{ $active_camera->koordinat }}</center>
                </h3>
            </span>
            <div class="progress-tinny">
                <div style="width: 10%" class="bar"></div>
            </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="order" id="orderClose">
            <div class="headline ">
                <h3>
                    <span style="background-color: #65C3DF">
                        <i class="maki-airport"></i>&#160;&#160;ARAH</span>
                </h3>
                <div class="titleClose">
                    <a href="#orderClose" class="gone">
                        <span class="entypo-cancel"></span>
                    </a>
                </div>
            </div>
            <span>
                <h3>
                    <center style="margin-top: 10px">{{ $active_camera->arah }}</center>
                </h3>
            </span>
            <div class="progress-tinny">
                <div style="width: 10%" class="bar"></div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-xs-12">
        <!-- data-chart -->
        {!! $chart->html() !!}
    </div>
</div>

<div class="row">


    <div class="col-lg-6">
        <iframe src="{{ config('app.url_friend') }}/?camera={{ $active_camera->id }}" width="600" height="450" scrolling="no" frameborder="0" style="margin: 30px auto 0;"></iframe>
    </div>


    <div class="col-lg-6">
        <div class="nest" id="FilteringClose">
            <div class="title-alt">
                <h6>
                    DATA KAMERA</h6>
                <div class="titleClose">
                    <a class="gone" href="#FilteringClose">
                        <span class="entypo-cancel"></span>
                    </a>
                </div>
                <div class="titleToggle">
                    <a class="nav-toggle-alt" href="#Filtering">
                        <span class="entypo-up-open"></span>
                    </a>
                </div>
            </div>

            <div class="body-nest" id="Filtering">
                <div class="row" style="margin-bottom:10px;">
                    <div class="col-sm-6">
                        <input class="form-control" id="filter" placeholder="Search..." type="text" />
                    </div>
                    <div class="col-sm-6">
                        <a href="#clear" style="margin-left:10px;" class="pull-right btn btn-info clear-filter" title="clear filter">clear</a>
                    </div>
                </div>

                <table id="footable-res2" class="demo" data-filter="#filter" data-filter-text-only="true">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Camera</th>
                            <th>Total</th>
                            <th>Vehicle</th>
                            <th>Datetime</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($count_rekap as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
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
        </div>
    </div>

</div>

@endsection

<!-- HEADER -->
@section('header')
<!-- TABLE -->
<link href="../../apricot/assets/js/footable/css/footable.core.css?v=2-0-1" rel="stylesheet" type="text/css" />
<link href="../../apricot/assets/js/footable/css/footable.standalone.css" rel="stylesheet" type="text/css" />
<link href="../../apricot/assets/js/footable/css/footable-demos.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../../apricot/assets/js/dataTable/lib/jquery.dataTables/css/DT_bootstrap.css" />
<link rel="stylesheet" href="../../apricot/assets/js/dataTable/css/datatables.responsive.css" />
<link rel="stylesheet" href="../../apricot/dark-chart.css" />

<!-- highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<style>
.footable > tbody > tr > td {color: #000 !important}
.footable > thead > tr > th, .footable > thead > tr > td {color: #000 !important}
</style>

@endsection

<!-- FOOTER -->
@section('footer')

<!-- Table -->
<script type="text/javascript" src="../../apricot/assets/js/toggle_close.js"></script>
<script src="../../apricot/assets/js/footable/js/footable.js?v=2-0-1" type="text/javascript"></script>
<script src="../../apricot/assets/js/footable/js/footable.sort.js?v=2-0-1" type="text/javascript"></script>
<script src="../../apricot/assets/js/footable/js/footable.filter.js?v=2-0-1" type="text/javascript"></script>
<script src="../../apricot/assets/js/footable/js/footable.paginate.js?v=2-0-1" type="text/javascript"></script>
<script src="../../apricot/assets/js/footable/js/footable.paginate.js?v=2-0-1" type="text/javascript"></script>



<script type="text/javascript">
    $(function() {
        $('#footable-res2').footable().bind('footable_filtering', function(e) {
            var selected = $('.filter-status').find(':selected').text();
            if (selected && selected.length > 0) {
                e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
                e.clear = !e.filter;
            }
        });

        $('.clear-filter').click(function(e) {
            e.preventDefault();
            $('.filter-status').val('');
            $('table.demo').trigger('footable_clear_filter');
        });

        $('.filter-status').change(function(e) {
            e.preventDefault();
            $('table.demo').trigger('footable_filter', {
                filter: $('#filter').val()
            });
        });

        $('.filter-api').click(function(e) {
            e.preventDefault();

            //get the footable filter object
            var footableFilter = $('table').data('footable-filter');

            alert('about to filter table by "tech"');
            //filter by 'tech'
            footableFilter.filter('tech');

            //clear the filter
            if (confirm('clear filter now?')) {
                footableFilter.clearFilter();
            }
        });
    });
</script>

{!! $chart->script() !!}

@endsection
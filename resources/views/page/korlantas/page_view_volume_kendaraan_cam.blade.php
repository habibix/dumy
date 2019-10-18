<!-- LAYOUT -->
@extends('layouts.page_app')

<!-- NAVBAR SECTION -->
@section('navbar')
@include('page.korlantas.page_nav')
@endsection

<!-- CONTENT -->
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="profit text-center" id="profitClose">
            <img class="img-circle img-responsive img-profile center-block" src="{{ asset('img') }}/{{ $operator->image }}" height="150px" width="200px">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <div id="RealTimeClose" class="nest" style="text-align:center;">
            <div class="title-alt" style="margin:0 !important">
                <h6>
                    <span class="fontawesome-resize-horizontal"></span>&nbsp;{{ $operator->name }} - {{ $selected_camera->lokasi }}</h6>
            </div>
            <iframe src="{{ config('app.url_friend') }}/?camera={{ $selected_camera->id }}" width="680px" height="480px" scrolling="no" frameborder="0"></iframe>
        </div>
    </div>
    <div class="col-sm-5">
        <div id="RealTimeClose" class="nest">
            <div class="title-alt" style="margin:0 !important">
                <h6>
                    <span class="fontawesome-resize-horizontal"></span>&nbsp;Database - {{ $operator->name }}</h6>
                <div class="titleClose">
                    <a class="gone" href="#RealTimeClose">
                        <span class="entypo-cancel"></span>
                    </a>
                </div>
                <div class="titleToggle">
                    <a class="nav-toggle-alt" href="#RealTime">
                        <span class="entypo-up-open"></span>
                    </a>
                </div>
            </div>
            <div id="RealTime" style="padding-top:2px; height: 484px;" class="body-nest">
                <div class="nest" id="FootableClose">
                    <div class="body-nest" id="Footable">

                        <table id="footable-res2" class="demo" data-filter="#filter" data-filter-text-only="true">
                            <thead>
                                <tr>
                                    <th data-toggle="true">
                                        No
                                    </th>
                                    <th>
                                        Tanggal & Jam
                                    </th>
                                    <th data-hide="phone,tablet">
                                        Jenis Kendaraan
                                    </th>
                                    <th data-hide="phone,tablet">
                                        Lokasi
                                    </th>
                                    <th>
                                        Jumlah
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($data_camera as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->created_at->format('D, d-M-Y') }}</td>
                                    <td>{{ ucfirst($data->vehicle) }}</td>
                                    <td>{{ $data->camera->lokasi }}</td>
                                    <td>{{ $data->total }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <div class="pagination pagination-centered"></div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>

                    </div>

                </div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-12">
        <!-- BLANK PAGE-->
        <div class="nest" id="Blank_PageClose">
            <div class="title-alt">
                <h6>
                    Volume Kendaraan</h6>
                <div class="titleClose">
                    <a class="gone" href="#Blank_PageClose">
                        <span class="entypo-cancel"></span>
                    </a>
                </div>
                <div class="titleToggle">
                    <a class="nav-toggle-alt" href="#Blank_Page_Content">
                        <span class="entypo-up-open"></span>
                    </a>
                </div>

            </div>

            <div class="body-nest" id="Blank_Page_Content">
            {!! $chart->html() !!}
            </div>
            
        </div>
    </div>
    <!-- END OF BLANK PAGE -->
</div>

@endsection

<!-- HEADER -->
@section('header')

<!-- TABLE -->
<link href="{{ asset('apricot/assets/js/footable/css/footable.core.css?v=2-0-1') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apricot/assets/js/footable/css/footable.standalone.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apricot/assets/js/footable/css/footable-demos.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apricot/assets/js/dataTable/lib/jquery.dataTables/css/DT_bootstrap.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apricot/assets/js/dataTable/css/datatables.responsive.css') }}" rel="stylesheet" type="text/css" />
<!--link href="{{ asset('apricot/dark-chart.css') }}" rel="stylesheet" type="text/css" /-->

<style>
    .footable>tbody>tr>td {
        color: #000 !important
    }

    .footable>thead>tr>th,
    .footable>thead>tr>td {
        color: #000 !important
    }


</style>


@endsection

<!-- FOOTER -->
@section('footer')

<!-- highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/themes/dark-unica.js"></script>

<!-- Table -->
<script src="{{ asset('../../apricot/assets/js/footable/js/toggle_close.js?v=2-0-1') }}" type="text/javascript"></script>
<script src="{{ asset('../../apricot/assets/js/footable/js/footable.js?v=2-0-1') }}" type="text/javascript"></script>
<script src="{{ asset('../../apricot/assets/js/footable/js/footable.sort.js?v=2-0-1') }}" type="text/javascript"></script>
<script src="{{ asset('../../apricot/assets/js/footable/js/footable.filter.js?v=2-0-1') }}" type="text/javascript"></script>
<script src="{{ asset('../../apricot/assets/js/footable/js/footable.paginate.js?v=2-0-1') }}" type="text/javascript"></script>

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
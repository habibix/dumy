<!-- LAYOUT -->
@extends('layouts.page_app')

<!-- NAVBAR SECTION -->
@section('navbar')
@include('page.korlantas.page_nav')
@endsection

<!-- CONTENT -->
@section('content')

<div class="row">
    <div class="col-sm-2">
        <div class="profit" id="profitClose">
            <img class="img-circle img-responsive img-profile" src="../../img/{{ $operator->image }}" height="150px" width="200px">
        </div>
    </div>
    <div class="col-sm-4">
        <div id="RealTimeClose" class="nest">
            <div class="title-alt" style="margin:0 !important">
                <h6>
                    <span class="fontawesome-resize-horizontal"></span>&nbsp;{{ $operator->name }} - {{ $random_camera->lokasi }}</h6>
            </div>
            <div id="RealTime" style="min-height:296px;padding-top:20px;" class="body-nest">
                {{ $random_camera->rtsp_address }}
            </div>
        </div>
    </div>
    <div class="col-sm-6">
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
            <div id="RealTime" style="min-height:295px;padding-top:2px;" class="body-nest">
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
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($data_camera as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->updated_at->format('D, d-M-Y H:i:s') }}</td>
                                    <td>{{ ucfirst($data->vehicle) }}</td>
                                    <td>{{ $data->camera->lokasi }}</td>
                                    <td>
                                        <span class="status-metro status-active" title="Active">Active</span>
                                    </td>
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

                <div id="container-chart" style="min-width: 300px; height: 400px; margin: 0 auto"></div>
            </div>
        </div>
    </div>
    <!-- END OF BLANK PAGE -->
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

<!-- Table -->
<script type="text/javascript" src="../../apricot/assets/js/toggle_close.js"></script>
<script src="../../apricot/assets/js/footable/js/footable.js?v=2-0-1" type="text/javascript"></script>
<script src="../../apricot/assets/js/footable/js/footable.sort.js?v=2-0-1" type="text/javascript"></script>
<script src="../../apricot/assets/js/footable/js/footable.filter.js?v=2-0-1" type="text/javascript"></script>
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

@endsection
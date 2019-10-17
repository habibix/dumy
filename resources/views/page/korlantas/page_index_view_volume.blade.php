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
        <div id="siteClose" class="nest">
            <div class="title-alt">
                <h6>
                    <span class="fontawesome-truck"></span>&nbsp;CCTV MAP Analytic</h6>
                <div class="titleClose">
                    <a class="gone" href="#siteClose">
                        <span class="entypo-cancel"></span>
                    </a>
                </div>
                <div class="titleToggle">
                    <a class="nav-toggle-alt" href="#site">
                        <span class="entypo-up-open"></span>
                    </a>
                </div>
            </div>
            <div id="site" class="body-nest" style="min-height:296px;">
                <div id='map' class='use-all-space'></div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-sm-12">
        <div id="RealTimeClose" class="nest">
            <div class="title-alt">
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
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        IP Camera
                                    </th>
                                    <th>
                                        Lokasi
                                    </th>
                                    <th>
                                        Arah
                                    </th>
                                    <th>
                                        Status
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach($cameras as $data)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $data->ip_camera }}</td>
                                    <td>{{ $data->lokasi }}</td>
                                    <td>{{ $data->arah }}</td>
                                    <td><span class="status-metro status-active" title="Active">Active</span></td>
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


@endsection

<!-- HEADER -->
@section('header')

<link rel="stylesheet" type="text/css" href='../../sdk/map.css' />
<link rel="stylesheet" type="text/css" href="../../sdk/elements.css">
<style type="text/css">
    #map {
        min-width: 320px;
        min-height: 400px;
        height: 600px;
        margin: auto;
        padding: 10px 10px 0 10px;
    }
</style>
<script src="../../sdk/js/form.js"></script>
<script src="../../sdk/tomtom.min.js"></script>

<!-- TABLE -->
<link href="../../apricot/assets/js/footable/css/footable.core.css?v=2-0-1" rel="stylesheet" type="text/css" />
<link href="../../apricot/assets/js/footable/css/footable.standalone.css" rel="stylesheet" type="text/css" />
<link href="../../apricot/assets/js/footable/css/footable-demos.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="../../apricot/assets/js/dataTable/lib/jquery.dataTables/css/DT_bootstrap.css" />
<link rel="stylesheet" href="../../apricot/assets/js/dataTable/css/datatables.responsive.css" />

<!-- highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/themes/dark-unica.js"></script>

<style>
    .footable>tbody>tr>td {
        color: #000 !important
    }

    .footable>thead>tr>th,
    .footable>thead>tr>td {
        color: #000 !important
    }
    .leaflet-popup-content-wrapper{width: 486px}
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

<script type="text/javascript">
    $(function() {
        $('#footable-res3').footable().bind('footable_filtering', function(e) {
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

<script type="text/javascript">
    //var speedyPizzaCoordinates = [{{ $operator->center_koordinat }}];
    var map = tomtom.L.map('map', {
        key: 'ViASnrhbgAvEijHSeUJD3DNJbSeC3dfO',
        basePath: '<your-tomtom-sdk-base-path>',
        center: [{{ $operator->center_koordinat }}],
        zoom: 9,
        traffic: {
                style: 's3',
                key: 'ViASnrhbgAvEijHSeUJD3DNJbSeC3dfO',
                trafficService: {
                    preserveCluster: true,
                    expandCluster: true,
                    language: 'en-GB'
                },
                createPopupForCluster: true,
                diff: true,
                minZoom: 4
            }
    });
    //var marker = tomtom.L.marker(speedyPizzaCoordinates).addTo(map);
    @foreach($cameras as $camera)
        var marker_{{$camera->id}} = tomtom.L.marker([{{ $camera->koordinat }}]).addTo(map);
        marker_{{$camera->id}}.bindPopup("<iframe src='{{ config('app.url_friend') }}/?camera={{ $camera->id }}' width='450' height='350'></iframe><p>Lokasi : {{$camera->lokasi}}</p><p>Wilayah : {{$camera->wilayah}}</p><p>Arah : {{$camera->arah}}</p>");
    @endforeach
    
</script>

@endsection
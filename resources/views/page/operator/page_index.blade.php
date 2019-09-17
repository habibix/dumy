<!-- LAYOUT -->
@extends('layouts.page_app')

<!-- NAVBAR SECTION -->
@section('navbar')
@include('page.operator.page_nav')
@endsection

<!-- CONTENT -->
@section('content')

<!--  DEVICE MANAGER -->

<div class="row">
    <div class="col-sm-3">
        <div class="member" id="memberClose">
            <div class="headline ">
                <h3>
                    <span>
                        <i class="entypo-camera"></i>&#160;&#160;Jumlah Kamera</span>
                </h3>
                <div class="titleClose">
                    <a href="#profitClose" class="gone">
                        <span class="entypo-cancel"></span>
                    </a>
                </div>
            </div>

            <div class="value">
                <span><i class="entypo-camera"></i>
                </span>10

            </div>

            <div class="progress-tinny">
                <div style="width: 50%" class="bar"></div>
            </div>
            <div class="profit-line">
                <i class="fa fa-caret-up fa-lg"></i>&#160;&#160; {{ Auth::user()->name }}</div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="revenue" id="revenueClose">
            <div class="headline ">

                <h3>
                    <span>
                        <i class="maki-bus"></i>&#160;&#160;Kecepatan Rata-rata</span>
                </h3>

                <div class="titleClose">
                    <a href="#revenueClose" class="gone">
                        <span class="entypo-cancel"></span>
                    </a>
                </div>
            </div>
            <div class="value">
                <span class="pull-left"><i class="entypo-gauge gauge-position"></i>
                </span>
                <canvas id="canvas4" width="70" height="70" margin-top="10px"></canvas>


            </div>

            <div class="progress-tinny">
                <div style="width: 25%" class="bar"></div>
            </div>
            <div class="profit-line">
                <i class="fa fa-caret-down fa-lg"></i>&#160;&#160;Kilometer/Jam</div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="profit" id="profitClose">
            <div class="headline ">
                <h3>
                    <span>
                        <i class="fontawesome-ban-circle"></i>&#160;&#160;PELANGGARAN</span>
                </h3>
                <div class="titleClose">
                    <a href="#profitClose" class="gone">
                        <span class="entypo-cancel"></span>
                    </a>
                </div>
            </div>

            <div class="value">
                <span class="pull-left"><i class="fontawesome-ban-circle clock-position"></i>
                </span>
                <span>
                    10
                </span>


            </div>

            <div class="progress-tinny">
                <div style="width: 50%" class="bar"></div>
            </div>
            <div class="profit-line">
                <i class="fa fa-caret-up fa-lg"></i>&#160;&#160; Total</div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class=" member" id="memberClose">
            <div class="headline ">
                <h3>
                    <span>
                        <i class="fa fa-truck"></i>
                        &#160;&#160;JUMLAH KENDARAAN
                    </span>
                </h3>
                <div class="titleClose">
                    <a href="#memberClose" class="gone">
                        <span class="entypo-cancel"></span>
                    </a>
                </div>
            </div>
            <div class="value">
                <span><i class="fa fa-truck"></i>
                </span>45000</b>

            </div>
            <div class="progress-tinny">
                <div style="width: 50%" class="bar"></div>
            </div>
            <div class="profit-line">
                <span class="entypo-down-circled"></span>&#160;50% From Last Month</div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <!-- Map box -->
        <div id='map' class='use-all-space'></div>
        <!-- /.box -->
    </div>
</div>

<!--  / DEVICE MANAGER -->

<!-- TABLE -->
<div class="row">
    <div class="col-sm-12">
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
                            <th>Wilayah</th>
                            <th>Lokasi</th>
                            <th>IP Camera</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($camera as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->wilayah }}</td>
                            <td>{{ $row->lokasi }}</td>
                            <td>{{ $row->ip_camera }}</td>
                            <td>{{ $row->status }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Wilayah</th>
                            <th>Lokasi</th>
                            <th>IP Camera</th>
                            <th>Status</th>
                        </tr>
                    </tfoot>
                </table>

            </div>

        </div>


    </div>

</div>
<!-- table -->

@endsection

<!-- HEADER -->
@section('header')
<!-- TABLE -->
<link href="apricot/assets/js/footable/css/footable.core.css?v=2-0-1" rel="stylesheet" type="text/css" />
<link href="apricot/assets/js/footable/css/footable.standalone.css" rel="stylesheet" type="text/css" />
<link href="apricot/assets/js/footable/css/footable-demos.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="apricot/assets/js/dataTable/lib/jquery.dataTables/css/DT_bootstrap.css" />
<link rel="stylesheet" href="apricot/assets/js/dataTable/css/datatables.responsive.css" />

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
@endsection

<!-- FOOTER -->
@section('footer')

<!-- GAGE -->
<script type="text/javascript" src="apricot/assets/js/speed/canvasgauge-coustom.js"></script>
<script type="text/javascript" src="apricot/assets/js/countdown/jquery.countdown.js"></script>
<script src="apricot/assets/js/jhere-custom.js"></script>

<!-- Table -->
<script type="text/javascript" src="../../apricot/assets/js/toggle_close.js"></script>
<script src="apricot/assets/js/footable/js/footable.js?v=2-0-1" type="text/javascript"></script>
<script src="apricot/assets/js/footable/js/footable.sort.js?v=2-0-1" type="text/javascript"></script>
<script src="apricot/assets/js/footable/js/footable.filter.js?v=2-0-1" type="text/javascript"></script>
<script src="apricot/assets/js/footable/js/footable.paginate.js?v=2-0-1" type="text/javascript"></script>
<script src="../../apricot/assets/js/footable/js/footable.paginate.js?v=2-0-1" type="text/javascript"></script>

<script>
    var gauge4 = new Gauge("canvas4", {
        'mode': 'needle',
        'range': {
            'min': 0,
            'max': 90
        }
    });
    gauge4.draw(Math.floor(Math.random() * 90));
    var run = setInterval(function() {
        gauge4.draw(Math.floor(Math.random() * 90));
    }, 3500);
</script>

<script type="text/javascript">
    $('#getting-started').countdown('2015/01/01', function(event) {
        $(this).html(event.strftime(

            '<span>%M</span>' + '<span class="start-min">:</span>' + '<span class="start-min">%S</span>'));
    });
</script>

<script type="text/javascript">
    tomtom.setProductInfo('tmaps', '0.1');
    var markerOptions = {
        icon: tomtom.L.icon({
            //iconUrl: 'https://api.tomtom.com/maps-sdk-js/4.47.6/examples/img/icon.png',
            iconUrl: 'https://icon-icons.com/icons2/390/PNG/512/cctv-camera_39530.png',
            iconSize: [30, 34],
            iconAnchor: [15, 34]
        })
    };

    var addressPoints = [
        [-6.243347, 106.8565551, 'ATMS 01 JPO KORLANTAS'],
        [-6.2379992, 106.8327819, 'ATMS 03 JPO TEBET 2'],
        [-6.2379133, 106.8327818, 'ATMS 09 JPO KUNINGAN'],
        [-6.2341636, 106.8207929, 'ATMS 10 JPO MAMPANG'],
        [-6.2341529, 106.8207929, 'ATMS 12 JPO JAMSOSTEK'],
        [-6.2428229, 106.8310242, 'ATMS 13 JPO TELKOM'],
        [-6.242715, 106.8047593, 'ATMS 14 JPO POLDA'],
        [-6.2149985, 106.8070094, 'ATMS 16 JPO SENAYAN-BARAT'],
        [-6.1850632, 106.7961225, 'ATMS 22 JPO HARAPAN KITA'],
        [-6.2102507, 106.819901, 'ATMS 26 JPO TAMAN-ANGGREK 2']
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
        basePath: '<your-tomtom-sdk-base-path>',
        iconUrl: 'https://icon-icons.com/icons2/390/PNG/512/cctv-camera_39530.png'
    });
    /*tomtom.L.marker([43.26456, -71.5702], markerOptions).addTo(map);
    tomtom.L.marker([39.73845, -104.98485], markerOptions).addTo(map);
    tomtom.L.marker([34.05224, -118.24334], markerOptions).addTo(map);
    tomtom.L.marker([37.78008, -122.42017], markerOptions).addTo(map);*/
    map.setView([-6.2106012, 106.8199012], 12);

    var markers = tomtom.L.markerClusterGroup();
    addressPoints.forEach(function(point) {
        var title = point[2],
            marker = tomtom.L.marker(new tomtom.L.LatLng(point[0], point[1]), {
                title: title
            });
        marker.bindPopup(title);
        markers.addLayer(marker);
    });
    map.addLayer(markers);
</script>

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
<!-- LAYOUT -->
@extends('layouts.page_app')

<!-- NAVBAR SECTION -->
@section('navbar')
@include('page.operator.page_nav')
@endsection

<!-- CONTENT -->
@section('content')

<div class="row">
    <div class="col-sm-2">
        <div class="dropdown form-group" style="margin-bottom: 0 !important;">
            <a href="#" class="dropdown-toggle form-control" data-toggle="dropdown">Pilih Lokasi<span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu">
                @foreach ($camera as $row)
                <li><a href="{{ route('anomali_id', $row->id) }}">{{ $row->lokasi }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- TABLE -->
<div class="row">
    <div class="col-sm-12">
        <div class="nest" id="FilteringClose">
            <div class="title-alt">
                <h6>DATA KAMERA - {{ $active_camera->lokasi }}</h6>
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

                <table id="footable-res2" class="demo" data-filter="#filter" data-filter-text-only="true" data-page-size="10" data-page-navigation=".pagination">
                    <thead>
                        <tr>
                            <th>
                                <center>No<center>
                            </th>
                            <th>
                                <center>Tanggal & Jam</center>
                            </th>
                            <th>
                                <center>Lokasi</center>
                            </th>
                            <th>
                                <center>Arah</center>
                            </th>
                            <th>
                                <center>Map</center>
                            </th>
                            <th>
                                <center>Jenis Pelanggaran</center>
                            </th>
                            <th>
                                <center>Video Clip</center>
                            </th>

                            <th>
                                <center>Capture Kamera</center>
                            </th>

                            <th>ETLE</th>

                        </tr>
                    </thead>

                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($anomali as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->created_at->format('Y-m-d h:i:s') }}</td>
                            <td>{{ $row->camera->lokasi }}</td>
                            <td>Cawang Menuju Grogol</td>
                            <td><a class="pop btn btn-info btn-lg" href="{{ config('app.url_root') }}/vca/{{ $row->image }}">Map</a></td>
                            <td>{{ $row->anomali }}</td>
                            <td><a href="#">{{ $row->video }}</a></td>
                            <td><a class="pop btn btn-info btn-lg" href="{{ config('app.url_root') }}/vca/{{ $row->image }}">Tampilkan Gambar</a></td>
                            <td><a class="pdf btn btn-info btn-lg" href="{{ config('app.url_root') }}/assets/test.pdf">Tilang</a></td>
                        </tr>
                        @endforeach

                    </tbody>

                    <tfoot class="hide-if-no-paging">
                        <tr>
                            <td colspan="9" class="text-center">
                                <ul class="pagination"></ul>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <img src="" class="imagepreview" style="width: 100%;">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="pdfmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:900px; height:800px">
            <div class="modal-content" >
                <div class="modal-body" style="height:600px">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <embed src="" class="pdfview" frameborder="0" width="100%" height="96%">
                </div>
            </div>
        </div>
    </div>

</div>
<!-- table -->

<div class="row">


    <div class="col-lg-6">
        <iframe src="{{ config('app.url_friend') }}" width="600" height="450" scrolling="no" frameborder="0" style="margin: 30px auto 0;"></iframe>
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

<script>
    $(function() {
        $('.pop').on('click', function(e) {
            e.preventDefault();
            //link = $(this).attr('href');
            $('.imagepreview').attr('src', $(this).attr('href'));
            //console.log(link)
            $('#imagemodal').modal('show');
        });
    });
</script>

<script>
    $(function() {
        $('.pdf').on('click', function(e) {
            e.preventDefault();
            //link = $(this).attr('href');
            $('.pdfview').attr('src', $(this).attr('href'));
            //console.log(link)
            $('#pdfmodal').modal('show');
        });
    });
</script>

@endsection
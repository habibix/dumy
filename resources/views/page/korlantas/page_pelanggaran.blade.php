<!-- LAYOUT -->
@extends('layouts.page_app')

<!-- NAVBAR SECTION -->
@section('navbar')
@include('page.korlantas.page_nav')
@endsection

<!-- CONTENT -->
@section('content')

<!-- TABLE -->
<div class="row">
    <div class="col-sm-8">
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
                                <center>Jenis Pelanggaran</center>
                            </th>
                            <th>
                                <center>Capture Kamera</center>
                            </th>

                            <th>ETLE</th>

                        </tr>
                    </thead>

                    <tbody>
                        @php $no = 1; @endphp
                        @foreach ($pelanggaran as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->created_at->format('Y-m-d h:i:s') }}</td>
                            <td>{{ $row->camera->lokasi }}</td>
                            <td>Cawang Menuju Grogol</td>
                            <td>{{ $row->anomali }}</td>
                            <td><a class="pop btn btn-info btn-lg" href="{{ config('app.url_root') }}/vca/{{ $row->image }}">Tampilkan Gambar</a></td>
                            <td><a class="pdf btn btn-info btn-lg" href="http://10.45.42.3/assets/test.pdf">Tilang</a></td>
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
    <div class="col-sm-4">
        <div id="RealTimeClose" class="nest">
            <div class="title-alt">
                <h6>
                    <span class="fontawesome-resize-horizontal"></span>&nbsp;Kategori Pelanggaran</h6>
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
            <div id="RealTime" style="min-height:296px;padding-top:20px;" class="body-nest">
                <ul class="direction">
                    <li>
                        <span class="" style="background:#FF6B6B"></span>
                        <h3>
                            <span>Melanggar Bahu Jalan</span>
                        </h3>
                        <p> Keterangan :</p>
                        <p>Kendaraan yang melalui bahu jalan</p>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <span class="" style="background:#65C3DF"></span>
                        <h3>
                            <span>Dilarang Berhenti</span>
                        </h3>
                        <p> Keterangan :</p>
                        <p>Berhenti pada area yang terlarang dalam waktu lebih dari 30 detik</p>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <span class="" style="background:#45B6B0"></span>
                        <h3>
                            <span>Lawan Arus</span>
                        </h3>
                        <p> Keterangan :</p>
                        <p>Kendaraan yang melakukan lawan arah</p>
                    </li>
                    <li class="divider"></li>
                </ul>
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
            <div class="modal-content">
                <div class="modal-body" style="height:600px">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <embed src="" class="pdfview" frameborder="0" width="100%" height="96%">
                </div>
            </div>
        </div>
    </div>

</div>
<!-- table -->

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
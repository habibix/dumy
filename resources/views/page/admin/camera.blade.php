<!-- LAYOUT -->
@extends('layouts.app')

<!-- NAVBAR SECTION -->
@section('navbar')
@include('page.admin.nav')
@endsection

<!-- CONTENT SECTION -->
@section('content')

<section class="content">

    <div class="col-md-12">

        @if (session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> {!! session('success') !!}</h4>
        </div>
        @endif

        @if (session('err'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> {!! session('err') !!}</h4>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Insert Camera</h3>
                </div>
                <form action="{{ route('addCamera') }}" method="post">
                    {{ csrf_field() }}
                    <div class="box-body">
                        <div class="form-group">
                            <label for="">Wilayah</label>
                            <input name="wilayah" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">Lokasi</label>
                            <input name="lokasi" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">IP Camera</label>
                            <input type="" name="ip_camera" class="form-control" placeholder="Example x.x.x.x">
                        </div>
                        <div class="form-group">
                            <label for="">Select User</label>
                            <select name="user_id" class="form-control">
                                <option value="">Pilih</option>
                                @foreach ($user as $row)
                                <option value="{{ $row->id }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">Camera Meta - Area Capture</label>
                            <input type="" name="area_capture" class="form-control" placeholder="Area Capture, example [x, x], [x, x], [x, x], [x, x]">
                        </div>

                        <div class="form-group">
                            <label for="">Camera Meta - Area Khusus</label>
                            <input type="" name="area_khusus" class="form-control" placeholder="Area Khusus, example [x, x], [x, x], [x, x], [x, x]">
                        </div>

                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="event_speed" value="1"><strong>Camera Meta - Event Speed </strong>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="event_counting" value="1"><strong>Camera Meta - Event Counting</strong>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="event_crossing" value="1"><strong>Camera Meta - Event Crossing</strong>
                            </label>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="restriced_area" value="1"><strong>Camera Meta - Restriced Area</strong>
                            </label>
                        </div>

                        <div class="form-group">
                            <button class="btn btn-primary btn-sm">
                                <i class="fa fa-send"></i> Save
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">List Camera</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="camera" class="table table-hover">
                            <thead>
                                <tr>
                                    <td>#</td>
                                    <td>Wilayah</td>
                                    <td>Lokasi</td>
                                    <td>IP Camera</td>
                                    <td>User</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @forelse ($camera as $row)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $row->wilayah }}</td>
                                    <td>{{ $row->lokasi }}</td>
                                    <td>{{ $row->ip_camera }}</td>
                                    <td>{{ $row->user['name'] }}</td>
                                    <td>
                                        <form action="{{ route('deleteUser', $row->id) }}" method="GET">
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

</section>
@endsection


<!-- HEADER SECTION -->
@section('header')
<script src="http://www.fasyasolusindo.com/tmaps/sdk/js/form.js"></script>
<script type='text/javascript' src='https://cdn.rawgit.com/jasonmoo/t.js/master/t.min.js'></script>
<script src="http://www.fasyasolusindo.com/tmaps/sdk/sdk/tomtom.min.js"></script>

<style type="text/css">
    #example-map {
        min-width: 320px;
        min-height: 400px;
        height: 400px;
        margin: auto;
        padding: 10px 10px 0 10px;
    }
</style>
@endsection

<!-- FOOTER SECTION -->
@section('footer')
<!-- highcharts -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<!-- DataTables -->
<script src="../../bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../../bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="http://www.fasyasolusindo.com/tmaps/sdk/sdk/tomtom.min.js"></script>
<script>
    $(function() {
        $('#list').DataTable({
            pageLength: 10
        })
        $('#camera').DataTable({
            pageLength: 10
        })
    })
</script>
@endsection
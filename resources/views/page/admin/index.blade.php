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
@endif @if ($errors->any())
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
<div class="col-md-6">
  <div class="box box-primary">
  <div class="box-header with-border">
    <h3 class="box-title">Add User</h3>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <form action="{{ route('addUser') }}" method="post" enctype="multipart/form-data">
  {{ csrf_field() }}
  <div class="box-body">
  <div class="form-group">
      <label for="">Nama</label>
      <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" required>
      <p class="text-danger">{{ $errors->first('name') }}</p>
  </div>
  <div class="form-group">
      <label for="">Email</label>
      <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid':'' }}" required>
      <p class="text-danger">{{ $errors->first('email') }}</p>
  </div>
  <div class="form-group">
      <label for="">Password</label>
      <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid':'' }}" required>
      <p class="text-danger">{{ $errors->first('password') }}</p>
  </div>
  <div class="form-group">
      <label for="">Role</label>
      <select name="role" class="form-control {{ $errors->has('role') ? 'is-invalid':'' }}" required>
          <option value="">Pilih</option>
          <option value="operator">Operator</option>
          <option value="admin">Admin</option>
          <option value="korlantas">Korlantas</option>
      </select>
      <p class="text-danger">{{ $errors->first('role') }}</p>
  </div>
  <div class="form-group">
      <label for="">Logo</label>
      <input type="file" name="image" class="form-control {{ $errors->has('image') ? 'is-invalid':'' }}" style="padding: 0px 12px !important" required>
      <p class="text-danger">{{ $errors->first('image') }}</p>
  </div>
  <div class="form-group">
      <button class="btn btn-primary btn-sm">
          <i class="fa fa-send"></i> Simpan
      </button>
  </div>
</div>
</form>
</div>

</div>

<div class="col-md-6">
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">List User</h3>
    </div>
      <div class="box-body">
        <div class="table-responsive">
          <table id="list" class="table table-hover">
              <thead>
                  <tr>
                      <td>#</td>
                      <td>Name</td>
                      <td>Email</td>
                      <td>Role</td>
                      <td>Created At</td>
                      <td></td>
                  </tr>
              </thead>
              <tbody>
                  @php $no = 1; @endphp
                  @forelse ($user as $row)
                  <tr>
                      <td>{{ $no++ }}</td>
                      <td>{{ $row->name }}</td>
                      <td>{{ $row->email }}</td>
                      <td>{{ $row->type }}</td>
                      <td>{{ $row->created_at }}</td>
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

<div class="row">
  <div class="col-md-6">
    <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">List User</h3>
    </div>
      <form action="{{ route('addCamera') }}" method="post">
        {{ csrf_field() }}
        <div class="box-body">
        <div class="form-group">
          <label for="">Wilayah</label>
          <input name="wilayah" class="form-control" required>
            <!-- <label for="">Wilayah</label>
            <select class="form-control" name="wilayah">
              <option value="">Pilih</option>
              <option value="ATMS">ATMS</option>
              <option value="ATMC">ATMC</option>
            </select> -->
        </div>
        <div class="form-group">
            <label for="">Lokasi</label>
            <input name="lokasi" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="">IP Camera</label>
            <input type="" name="ip_camera" class="form-control" placeholder="Example x.x.x.x" required>
        </div>
        <div class="form-group">
            <label for="">Select User</label>
            <select name="user_id" class="form-control" required>
                <option value="">Pilih</option>
                @foreach ($user as $row)
                <option value="{{ $row->id }}">{{ $row->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-sm">
                <i class="fa fa-send"></i> Simpan
            </button>
        </div>
      </div>
      </form>
    </div>
  </div>
  <div class="col-md-6">
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
  $(function () {
    $('#list').DataTable({
      pageLength : 6
    })
    $('#camera').DataTable({
      pageLength : 6
    })
  })
</script>
@endsection
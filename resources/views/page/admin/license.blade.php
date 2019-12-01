<!-- LAYOUT -->
@extends('layouts.app')

<!-- NAVBAR SECTION -->
@section('navbar')
@include('page.admin.nav')
@endsection

<!-- CONTENT SECTION -->
@section('content')

<section class="content">

    <!-- SELECT2 EXAMPLE -->
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title">Insert License</h3>

            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">

            <div class="row">
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
            </div>

            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('insert_license') }}" method="POST" enctype="multipart/form-data" role="form">
                        <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                        <div class="box-body">
                            <div class="form-group">
                                <!-- <label for="exampleInputFile">File input</label> -->
                                <input name="license" type="file" id="exampleInputFile">
                                <p class="help-block">Insert .lic file</p>
                            </div>
                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->


        </div>
        <!-- /.box-body -->

        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">VCA Pro License</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>License Type</th>
                                    <th>Camera Count</th>
                                </tr>
                                @php $i = 1 @endphp
                                @foreach($license as $lic)
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{ $lic->license_type }}</td>
                                    <td>{{ $lic->license_camera }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

    </div>
    <!-- /.box -->

</section>

@endsection


<!-- HEADER SECTION -->
@section('header')

@endsection

<!-- FOOTER SECTION -->
@section('footer')

@endsection
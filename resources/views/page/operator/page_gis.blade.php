<!-- LAYOUT -->
@extends('layouts.page_app')

<!-- NAVBAR SECTION -->
@section('navbar')
@include('page.operator.page_nav')
@endsection

<!-- CONTENT -->
@section('content')

<iframe src="{{ route('gis2') }}" width="100%" height="800px" scrolling="no" frameborder="0" style="margin: 30px auto 0;"></iframe>

@endsection

<!-- HEADER -->
@section('header')
<!-- TABLE -->


@endsection

<!-- FOOTER -->
@section('footer')


@endsection
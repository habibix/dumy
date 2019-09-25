<!-- LAYOUT -->
@extends('layouts.page_app')

<!-- NAVBAR SECTION -->
@section('navbar')

@endsection

<!-- CONTENT -->
@section('content')

<div class="row">
    
    @foreach($cameras_random as $camera)
    <div class="col-sm-6">
        <div id="RealTimeClose" class="nest">
            <div class="title-alt">
                <h6>
                    <span class="fontawesome-resize-horizontal"></span>&nbsp;CCTV ANALYTIC</h6>
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
            <div id="RealTime" class="body-nest">
            <iframe src="{{ config('app.url_friend') }}/speed/?camera={{ $camera->id }}" width="680px" height="480px" scrolling="no" frameborder="0"></iframe>
            </div>
        </div>
    </div>
    @endforeach
</div>

@endsection

<!-- HEADER -->
@section('header')



@endsection

<!-- FOOTER -->
@section('footer')



@endsection
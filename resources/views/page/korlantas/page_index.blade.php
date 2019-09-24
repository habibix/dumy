<!-- LAYOUT -->
@extends('layouts.page_app')

<!-- NAVBAR SECTION -->
@section('navbar')

@endsection

<!-- CONTENT -->
@section('content')

<div class="row">
    @foreach($operators as $operator)
    <div class="col-sm-3">
        <div class="profit" id="profitClose">
            <div class="value">
                <a href="{{ route('index_view_volume', $operator->id) }}"><img src="../../img/{{ $operator->image }}" height="150px" width="200px"></a>
            </div>
            <div class="progress-tinny">
                <div style="width: 50%" class="bar"></div>
            </div>
            <div class="profit-line">
                <i class="fa fa-caret-up fa-lg"></i> Jumlah Kamera {{ $operator->punya_kamera_count }}</div>
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
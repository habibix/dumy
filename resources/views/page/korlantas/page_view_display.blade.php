<!-- LAYOUT -->
@extends('layouts.page_app')

<!-- NAVBAR SECTION -->
@section('navbar')

@endsection

<!-- CONTENT -->
@section('content')

<div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="profit" style="color: #000;">
            <div class="form-group">
                <label for="sel1">Pilih Jenis Analitik</label>
                <select class="form-control" id="select_event">
                    <option value="speed">Analisa kecepatan</option>
                    <option value="counting">Perhitungan Kendaraan</option>
                </select>
            </div>

            <div class="form-group">
                <label for="sel1">Pilih Kamera</label>
                <select class="form-control" id="select_camera">
                    <option value="">Pilih Kamera</option>
                    @foreach($cameras as $camera)
                    <option value="{{ $camera->id }}">{{ $camera->lokasi }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>

@endsection

<!-- HEADER -->
@section('header')

<script>
    $(document).ready(function() {
        // http://127.0.0.1:5000/speed/?camera=1
        // http://127.0.0.1:5000/?camera=1

        $('#select_camera').on('change', function() {
            //var optionValue = $(this).val();
            //var optionText = $('#dropdownList option[value="'+optionValue+'"]').text();
            var selectedEvent = $("#select_event option:selected").val();
            var selectedCamera = $("#select_camera option:selected").val();

            var url = "{{ config('app.url_friend') }}";

            if (selectedEvent == 'speed') {
                //url
                //window.open(url, '_blank');
                url = url + "/speed/?camera=" + selectedCamera
                window.open(url, '_blank');
            } else if (selectedEvent == 'counting') {
                url = url + "/?camera=" + selectedCamera
                window.open(url, '_blank');
            }

            //alert("Selected Option Text: " + url);
        });
    });
</script>

@endsection

<!-- FOOTER -->
@section('footer')


@endsection
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Chart with VueJS</title>
    <link rel="stylesheet" href="http://127.0.0.1:8000/apricot/assets/css/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('apricot/assets/css/bootstrap.css') }}">

</head>

<body>
<div class="col-sm-3"><input type="text" class="form-control" id="dp1" value="02-16-2012"></div>
    <div id="app">
        {!! $chart->container() !!}
    </div>
    <script src="https://unpkg.com/vue"></script>
    <script>
        var app = new Vue({
            el: '#app',
        });
    </script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.js"></script>
    <script type="text/javascript" src="{{ asset('apricot/assets/js/bootstrap.js') }}"></script>
    <script src=https://cdnjs.cloudflare.com/ajax/libs/echarts/4.0.2/echarts-en.min.js charset=utf-8></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/6.0.6/highcharts.js" charset="utf-8"></script>
    <script type="text/javascript" src="{{ asset('../../apricot/assets/js/datepicker/bootstrap-datepicker.js') }}"></script>
    
    {!! $chart->script() !!}

    <script type="text/javascript">
        
        url = {{ $chart->id }}_api_url

        $('#dp1').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true
        }).on('changeDate', function(e) {
            //console.log(e.format());
            newEndPoint = $('#dp1').val()
            console.log($('#dp1').val());
            
            newUrl = url+"/"+newEndPoint
            {{ $chart->id }}_refresh(newUrl);

            
            console.log(newUrl);

            $('#dp1').datepicker('hide');
        });
    </script>
</body>

</html>
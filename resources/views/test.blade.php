<!DOCTYPE html>
<html class='use-all-space'>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta charset='UTF-8'>
    <title>Maps SDK for Web - Custom marker image</title>
    <meta name='viewport' content='width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no'/>
    <link rel='stylesheet' type='text/css' href='sdk/map.css'/>
    <link rel='stylesheet' type='text/css' href='sdk/elements.css'/>
    <script type='text/javascript' src='sdk/js/form.js'></script>
    <script type='text/javascript' src='sdk/tomtom.min.js'></script>
</head>
<body class='use-all-space'>
    <div id='map' class='use-all-space'></div>
    <script>
    // Define your product name and version
    tomtom.setProductInfo('<your-product-name>', '<your-product-version>');
    var markerOptions = {
        icon: tomtom.L.icon({
            iconUrl: 'https://api.tomtom.com/maps-sdk-js/4.47.6/examples/img/icon.png',
            iconSize: [30, 34],
            iconAnchor: [15, 34]
        })
    };

    var map = tomtom.map('map', {
        key: 'ViASnrhbgAvEijHSeUJD3DNJbSeC3dfO',
        source: 'raster',
        basePath: '<your-tomtom-sdk-base-path>'
    });
    tomtom.L.marker([43.26456, -71.5702], markerOptions).addTo(map);
    tomtom.L.marker([39.73845, -104.98485], markerOptions).addTo(map);
    tomtom.L.marker([34.05224, -118.24334], markerOptions).addTo(map);
    tomtom.L.marker([37.78008, -122.42017], markerOptions).addTo(map);
    map.setView([39, -97.5], 4);
    </script>
</body>
</html>
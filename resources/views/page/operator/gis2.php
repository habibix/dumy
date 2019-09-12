<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>VCA PRO</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../../bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <link rel='stylesheet' type='text/css' href='../../sdk/map.css' />
  <link rel='stylesheet' type='text/css' href='../../sdk/elements.css' />

  <script type='text/javascript' src='../../sdk/form.js'></script>
  <script type='text/javascript' src='https://cdn.rawgit.com/jasonmoo/t.js/master/t.min.js'></script>
  <script type='text/javascript' src='../../sdk/tomtom.min.js'></script>
  <style>
      .map-container {
          margin-left: 40%;
          width: 60%;
      }

      .container {
          min-height: 600px;
      }

      .selected-row {
          background-color: lightgray;
      }

      #example {
          height: 600px;
      }

      hr {
          margin: 0;
      }

      .traffic-incidents-list-container{
        max-height: 600px !important;
      }
  </style>

<style type="text/css">
#map {
min-width: 320px;
min-height: 400px;
height: 600px;
margin: auto;
padding: 10px 10px 0 10px;
}
</style>


</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>V</b>CA</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>VCA</b>PRO</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="../../dist/img/logo-polda-metro.png" class="user-image" alt="User Image">
              <span class="hidden-xs">RTMC Polda Metro</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../../dist/img/logo-polda-metro.png" class="img-circle" alt="User Image">

                <p>
                  RTMC Polda Metro - operator
                </p>
              </li>

              <li class="user-footer">
                <!-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div> -->
                <div class="pull-right">
                  <a class="btn btn-default btn-flat" href="http://127.0.0.1:8000/logout" class="dropdown-item notify-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fe-log-out"></i>
                    <span>Logout</span>
                    <form id="logout-form" action="http://127.0.0.1:8000/logout" method="POST" style="display: none;"><input type="hidden" name="_token" value="28jcsZbKzCCsypkhmKGSTs0otoj7kAFPB5yFLZjo"> </form>
                </a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
        </ul>
      </div>

    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../../dist/img/logo-polda-metro.png" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>RTMC Polda Metro</p>
          <p>operator</p>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      
      	<ul class="sidebar-menu" data-widget="tree">
  <li class="header">MAIN NAVIGATION</li>
  <li class="">
    <a href="http://127.0.0.1:8000/operator"><i class="fa fa-dashboard"></i> <span>Camera List</span></a>
  </li>
  <li class="">
    <a href="http://127.0.0.1:8000/operator/counting"><i class="fa fa-dashboard"></i> <span>Vehicle Counting</span></a>
  </li>
  <li class="">
    <a href="http://127.0.0.1:8000/operator/speed"><i class="fa fa-dashboard"></i> <span>Speed Analysis</span></a>
  </li>
  <li class="">
    <a href="#4"><i class="fa fa-dashboard"></i> <span>Anomali Analysis</span></a>
  </li>
  <li class="">
    <a href="/operator/gis"><i class="fa fa-dashboard"></i> <span>GIS</span></a>
  </li>

</ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">

      <div class='container use-all-space'>
        <div class='traffic-incidents-list-container'>
            <table id='trafficIncidentsList' cellspacing='0' width='100%' class='hover'>
                <thead>
                    <tr>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class='map-container use-all-space'>
            <div id='map' class='use-all-space'></div>
        </div>
    </div>
    <script id='headersTemplate' type='t/template'>
        <th>
            <div class='headerContainer clickable-header'>
                <span>{{=name}}</span> {{sortable}}
                <div class='arrows'>
                    <div class='arrow-up'></div>
                    <div class='arrow-down'></div>
                </div>
                {{:sortable}} {{/sortable}}
            </div>
        </th>
    </script>
    <script id='incidentsListRowTemplate' type='t/template'>
        <td>
            <div class='traffic-icon'>
                <div class='icon-circle-{{=incidentSeverity}}'>
                    <div class='{{=icon}} traffic-incidents-list-icon'>{{=incidentsNo}}</div>
                </div>
            </div>
        </td>
        <td>
            <b>{{=roadNumber}}</b>
            <div>{{=from}}</div>
            <div>{{=to}}</div>
        </td>
        <td class='traffic-incidents-list-number-cell'>{{=delay}}</td>
        <td class='traffic-incidents-list-number-cell'>{{=length}}</td>
    </script>
    <script id='noTrafficRowTemplate' type='t/template'>
        <td valign='top' colspan='4' class='empty-row'><b>No data for this view, try to move or zoom...</b></td>
        <td></td>
        <td></td>
        <td></td>
    </script>
    <script>

        // Define your product name and version
        tomtom.setProductInfo('<your-product-name>', '<your-product-version>');
        // Prepare a map and TomTom keys
        var map = tomtom.map('map', {
            key: 'ViASnrhbgAvEijHSeUJD3DNJbSeC3dfO',
            source: ['raster'],
            traffic: {
                style: 's3', key: 'ViASnrhbgAvEijHSeUJD3DNJbSeC3dfO',
                trafficService: {
                    preserveCluster: true,
                    expandCluster: true,
                    language: 'en-GB'
                },
                createPopupForCluster: true,
                diff: true,
                minZoom: 10
            },
            center: [-6.2106012,106.8199012],
            zoom: 10,
            dragging: false,
            touchZoom: false,
            scrollWheelZoom: false,
            doubleClickZoom: false,
            boxZoom: false,
            tap: false,
            keyboard: false,
            zoomControl: false,
        });


        var trafficIncidentsListData, trafficLayer, trafficIncidentsLayer,
            popupOpenerTimeoutHandler, emptyField = '----';

        var trafficIncidentsListBody = document.querySelector('#trafficIncidentsList tbody');
        var rowTemplate = new t(document.getElementById('incidentsListRowTemplate').innerHTML);
        var noTrafficRowTemplateContent = new t(document.getElementById('noTrafficRowTemplate').innerHTML).render();

        var tableHeaders = document.querySelector('#trafficIncidentsList thead tr');
        var headersTemplate = new t(document.getElementById('headersTemplate').innerHTML);
        var headersDefinitions = [
            { name: '' },
            { name: 'Incidents', sortable: true },
            { name: 'Delay', sortable: true },
            { name: 'Length', sortable: true }
        ];

        var columnName, sortDirection;
        var shouldUpdate = true;
        var activeMarker = null;

        // Handling new incidents data
        var incidentsLayers = L.MapUtils.findLayersByName('trafficIncidents', map);
        if (incidentsLayers.length) {
            var incidentsLayer = incidentsLayers[0];
            incidentsLayer.on(L.TomTomTrafficIncidentsLayer.Events.TRAFFIC_INCIDENTS_RECEIVED, function(event) {
                trafficIncidentsListData = event.layers.map(function(layer) {
                    return buildTrafficListRow(layer.feature, layer);
                });
                if (columnName && sortDirection) {
                    trafficIncidentsListData.sort(compareBuilder(columnName, sortDirection));
                }
                if (shouldUpdate) {
                    renderTrafficIncidentsList();
                } else {
                    shouldUpdate = true;
                }
                if (activeMarker) {
                    incidentsLayer.getLayers().filter(function(layer) {
                        return layer.getLatLng().equals(activeMarker.getLatLng());
                    }).forEach(function(layer) {
                        layer.openPopup();
                    });
                    activeMarker = null;
                }
            });
            incidentsLayer.on('click', function(event) {
                activeMarker = event.propagatedFrom;
                L.MapUtils.setViewWithOffset(map, activeMarker.getLatLng(), map.getZoom(), {}, {
                    x: 0,
                    y: offsetForPopup()
                });
            });
        }


        map.on('zoom', function() {
            var currentZoom = map.getZoom();
            if (currentZoom < 10 && !trafficLayer) {
                trafficLayer = L.MapUtils.findLayersByName('traffic', map)[0];
                trafficIncidentsLayer = L.MapUtils.findLayersByName('trafficIncidents', map)[0];
                map.removeLayer(trafficLayer);
                trafficIncidentsLayer.clearLayers();
                map.removeLayer(trafficIncidentsLayer);
                trafficIncidentsListData = [];
                renderTrafficIncidentsList();
            } else if (currentZoom >= 10 && trafficLayer) {
                map.addLayer(trafficLayer);
                map.addLayer(trafficIncidentsLayer);
                trafficLayer = null;
                trafficIncidentsLayer = null;
            }
        });

        function getPropertyAsText(property, defaultValue) {
            return property ? property : (defaultValue === undefined ? emptyField : defaultValue);
        }

        function changeSizeOfIcon(layer, newIconSize) {
            var newScale = 'scale(' + newIconSize + ')';
            var container = layer.options.icon.container;

            if (/scale/.test(container.style.transform)) {
                container.style.transform = container.style.transform.replace(/scale\(.+\)?/, newScale);
            } else {
                container.style.transform = container.style.transform + ' ' + newScale;
            }

            container.style['margin-left'] = (parseInt(container.style.height) / -2) * newIconSize + 'px';
            container.style['margin-right'] = (parseInt(container.style.width) / -2) * newIconSize + 'px';
        }

        function formatTime(timeInSec) {
            if (!timeInSec) {
                return emptyField;
            }

            var mins = parseInt(timeInSec / 60);
            var sec = timeInSec % 60;
            if (mins) {
                var result = String(mins);
                if (sec) {
                    result += ':' + (sec < 10 ? '0' + sec : sec);
                }
                return result + ' min';
            } else {
                return sec + ' s';
            }
        }

        function formatLength(lengthInMeters) {
            if (!lengthInMeters) {
                return emptyField;
            }

            if (lengthInMeters > 1000) {
                return (lengthInMeters / 1000).toPrecision(3) + ' km';
            }
            return lengthInMeters + ' m';
        }

        function getDelay(feature) {
            var finalDelay = 0, features, featureDelay;
            if (isClusteredFeature(feature)) {
                features = feature.properties.features;
                for (var i = 0; i < features.length; ++i) {
                    featureDelay = features[i].properties.delaySeconds ? features[i].properties.delaySeconds : 0;
                    finalDelay += featureDelay;
                }
            } else {
                featureDelay = feature.properties.delaySeconds ? feature.properties.delaySeconds : 0;
                finalDelay = featureDelay;
            }
            return finalDelay;
        }

        function isClusteredFeature(feature) {
            return Boolean(feature.properties.features);
        }

        function prepareRowData(feature, layer) {
            var mainFeatureProperties = feature.properties;
            if (isClusteredFeature(feature)) {
                mainFeatureProperties = feature.properties.features[0].properties;
            }

            var icon = layer.options.icon.options.icon ? layer.options.icon.options.icon.icon : '';
            var rawDelay = getDelay(feature);
            return {
                icon: icon,
                rawDelay: rawDelay,
                delay: getPropertyAsText(formatTime(rawDelay)),
                rawLength: feature.properties.lengthMeters,
                length: getPropertyAsText(formatLength(feature.properties.lengthMeters)),
                incidentSeverity: feature.properties.incidentSeverity || 'unknown',
                from: mainFeatureProperties.from,
                to: mainFeatureProperties.to,
                roadNumber: mainFeatureProperties.roadNumber,
                incidentsNo: isClusteredFeature(feature) ? feature.properties.features.length : ''
            };
        }

        function offsetForPopup() {
            try {
                return activeMarker.openPopup().getPopup().getElement().getBoundingClientRect().width * 0.5;
            } catch (err) {
                return 0;
            }
        }


        // Build a row in the table
        function buildTrafficListRow(feature, layer) {
            var rowData = prepareRowData(feature, layer);
            var rowContent = rowTemplate.render(rowData);
            var row = document.createElement('tr');
            row.innerHTML = rowContent;

            row.addEventListener('mouseover', function() {
                changeSizeOfIcon(layer, 2);
                if (layer._popup) {
                    if (popupOpenerTimeoutHandler) {
                        clearTimeout(popupOpenerTimeoutHandler);
                    }
                    popupOpenerTimeoutHandler = setTimeout(function() {
                        layer.openPopup();
                    }, 500);
                }
            });

            row.addEventListener('mouseout', function() {
                changeSizeOfIcon(layer, 1);
                if (popupOpenerTimeoutHandler) {
                    clearTimeout(popupOpenerTimeoutHandler);
                    popupOpenerTimeoutHandler = null;
                }
            });

            function unselectRows() {
                var previous = document.querySelector('.selected-row');
                if (previous) {
                    previous.classList.remove('selected-row');
                }
            }


            row.addEventListener('click', function() {
                shouldUpdate = false;
                activeMarker = layer;
                L.MapUtils.setViewWithOffset(map, activeMarker.getLatLng(), map.getZoom(), {}, {
                    x: 0,
                    y: offsetForPopup()
                });
                unselectRows();
                row.classList.add('selected-row');
            });

            layer.on('popupopen', function() {
                row.classList.add('selected-row');
            });
            layer.on('popupclose', function(event) {
                if (event.sourceTarget.getElement()) {
                    unselectRows();
                }
            });

            return { row: row, data: rowData };
        }



        // Render the list
        function renderTrafficIncidentsList() {
            var noTrafficRow;
            trafficIncidentsListBody.innerHTML = '';

            if (trafficIncidentsListData && trafficIncidentsListData.length > 0) {
                if (!tableHeaders.innerText) {
                    buildHeaders();
                }

                trafficIncidentsListData.forEach(function(item) {
                    trafficIncidentsListBody.appendChild(item.row);
                });
            } else {
                tableHeaders.innerHTML = '';
                noTrafficRow = document.createElement('tr');
                noTrafficRow.innerHTML = noTrafficRowTemplateContent;
                trafficIncidentsListBody.appendChild(noTrafficRow);
            }
        }

        // Comparator used when sorting results
        function compareBuilder(columnName, direction) {
            var modifier = direction === 'asc' ? 1 : -1;
            return function(a, b) {
                if (typeof a.data[columnName] === 'string') {
                    return modifier * a.data[columnName].localeCompare(b.data[columnName]);
                }
                return modifier * (a.data[columnName] - b.data[columnName]);
            };
        }



        // Clickable table headers
        function buildHeaders() {
            while (tableHeaders.firstChild) {
                tableHeaders.removeChild(tableHeaders.firstChild);
            }

            tableHeaders.innerHTML = headersDefinitions.map(function(item) {
                return headersTemplate.render(item);
            }).join(' ');

            var headers = document.querySelectorAll('#trafficIncidentsList th');

            Array.prototype.forEach.call(headers, function(header) {

                header.addEventListener('click', function() {
                    switch (this.innerText.trim()) {
                    case 'Incidents': columnName = 'from'; break;
                    case 'Delay': columnName = 'rawDelay'; break;
                    case 'Length': columnName = 'rawLength'; break;
                    }
                    var arrowsContainer = this.querySelector('.arrows');
                    if (arrowsContainer) {
                        sortDirection = arrowsContainer.classList.contains('sorting-asc') ? 'asc' : 'desc';
                        if (sortDirection === 'asc') {
                            arrowsContainer.classList.remove('sorting-asc');
                            arrowsContainer.classList.add('sorting-desc');
                        } else {
                            arrowsContainer.classList.add('sorting-asc');
                            arrowsContainer.classList.remove('sorting-desc');
                        }
                        trafficIncidentsListData.sort(compareBuilder(columnName, sortDirection));
                        renderTrafficIncidentsList();
                    }
                });
            });
        }


    </script>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.13
    </div>
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">VCA PRO</a>.</strong> All rights
    reserved.
  </footer>
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>

<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>

</body>
</html>
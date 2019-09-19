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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

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

        .traffic-incidents-list-container {
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
                    style: 's3',
                    key: 'ViASnrhbgAvEijHSeUJD3DNJbSeC3dfO',
                    trafficService: {
                        preserveCluster: true,
                        expandCluster: true,
                        language: 'en-GB'
                    },
                    createPopupForCluster: true,
                    diff: true,
                    minZoom: 10
                },
                center: [-6.2106012, 106.8199012],
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
            var headersDefinitions = [{
                    name: ''
                },
                {
                    name: 'Incidents',
                    sortable: true
                },
                {
                    name: 'Delay',
                    sortable: true
                },
                {
                    name: 'Length',
                    sortable: true
                }
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
                var finalDelay = 0,
                    features, featureDelay;
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

                return {
                    row: row,
                    data: rowData
                };
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
                            case 'Incidents':
                                columnName = 'from';
                                break;
                            case 'Delay':
                                columnName = 'rawDelay';
                                break;
                            case 'Length':
                                columnName = 'rawLength';
                                break;
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

</body>

</html>
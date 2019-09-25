<div id="skin-select">
    <div id="logo">
        <h1>VCA PRO
            <span>v1.1</span>
        </h1>
    </div>

    <a id="toggle">
        <span class="entypo-menu"></span>
    </a>
    <div class="dark">
        <form action="#">
            <span>
                <input type="text" name="search" value="" class="search rounded id_search" placeholder="Search Menu..." autofocus />
            </span>
        </form>
    </div>

    <div class="search-hover">
        <form id="demo-2">
            <input type="search" placeholder="Search Menu..." class="id_search">
        </form>
    </div>


    <div class="search-hover">
        <form id="demo-2">
            <input type="search" placeholder="Search Menu..." class="id_search">
        </form>
    </div>

    <div class="skin-part">
        <div id="tree-wrap">
            <div class="side-bar">
                <ul class="topnav menu-left-nest">
                    <li>
                        <a href="#" style="border-left:0px solid!important;" class="title-menu-left">

                            <span class="widget-menu"></span>
                            <i data-toggle="tooltip" class="entypo-cog pull-right config-wrap"></i>

                        </a>
                    </li>

                    <li>
                        <a class="tooltip-tip ajax-load" href="{{ route('operator') }}" title="List Kamera">
                            <i class="icon-feed"></i>
                            <span>List Kamera</span>

                        </a>
                    </li>

                    <li>
                        <a class="tooltip-tip ajax-load" href="{{ route('operator_counting') }}" title="Counting">
                            <i class="entypo-chart-bar"></i>
                            <span>Analisa Perhitungan</span>

                        </a>
                    </li>
                    <li>
                        <a class="tooltip-tip ajax-load" href="{{ route('operator_speed') }}" title="Speed">
                            <i class="fontawesome-bolt"></i>
                            <span>Analisa Kecepatan</span>

                        </a>
                    </li>
                    <li>
                        <a class="tooltip-tip ajax-load" href="{{ route('anomali') }}" title="Media">
                            <i class="fontawesome-ban-circle"></i>
                            <span>Pelanggaran</span>

                        </a>
                    </li>

                    <li>
                        <a class="tooltip-tip ajax-load" href="{{ route('macet') }}" title="Media">
                            <i class="fontawesome-truck"></i>
                            <span>Arus Lalu Lintas</span>

                        </a>
                    </li>

                    <li>
                        <a class="tooltip-tip ajax-load" href="{{ route('operator_gis') }}" title="Media">
                            <i class="icon icon-map"></i>
                            <span>GIS</span>

                        </a>
                    </li>
                </ul>


                <div class="side-dash">
                    <h3>
                        <span>Device</span>
                    </h3>
                    <ul class="side-dashh-list">
                        <li>Avg. Traffic
                            <span>25k<i style="color:#44BBC1;" class="fa fa-arrow-circle-up"></i>
                            </span>
                        </li>
                        <li>Visitors
                            <span>80%<i style="color:#AB6DB0;" class="fa fa-arrow-circle-down"></i>
                            </span>
                        </li>
                        <li>Convertion Rate
                            <span>13m<i style="color:#19A1F9;" class="fa fa-arrow-circle-up"></i>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
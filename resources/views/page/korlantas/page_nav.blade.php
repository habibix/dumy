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

                            <span class="">Menu</span>
                            <i data-toggle="tooltip" class="entypo-cog pull-right config-wrap"></i>

                        </a>
                    </li>


                    <li>
                        <a class="tooltip-tip " href="{{ route('korlantas') }}" title="login">
                            <i class="entypo-home"></i>
                            <span>Home</span>
                        </a>
                    </li>

                    <li>
                        <a class="tooltip-tip " href="#" title="login">
                            <i class="icon icon-feed"></i>
                            <span>Data CCTV Analytic</span>
                        </a>
                    </li>

                    <li>
                        <a class="tooltip-tip " href="{{ route('view_display', $operator->id) }}" title="login">
                            <i class="icon icon-feed"></i>
                            <span>Viewer</span>
                        </a>
                    </li>

                </ul>

                <ul class="topnav menu-left-nest">
                    <li>
                        <a href="#" style="border-left:0px solid!important;" class="title-menu-left">

                            <span class="">Menu</span>
                            <i data-toggle="tooltip" class="entypo-cog pull-right config-wrap"></i>

                        </a>
                    </li>

                    <li>
                        <a class="tooltip-tip" href="#" title="Extra Pages">
                            <i class="icon-document-new"></i>
                            <span>Volume Kendaraan</span>
                        </a>
                        <ul>
                            @foreach ($cameras as $camera)
                            <li>
                                <a class="tooltip-tip2 ajax-load" href="{{route('view_volume_kendaraan_cam',['id_user'=>$operator->id, 'id_camera'=>$camera->id])}}" title="Blank Page"><i class="icon-media-record"></i><span>{{ substr($camera->lokasi, 0, 22) }}</span></a>
                            </li>
                            @endforeach
                        </ul>
                    </li>

                    <li>
                        <a class="tooltip-tip" href="#" title="Extra Pages">
                            <i class="icon-document-new"></i>
                            <span>Analisa Kecepatan</span>
                        </a>
                        <ul>
                            @foreach ($cameras as $camera)
                            <li>
                                <a class="tooltip-tip2 ajax-load" href="{{route('view_speed_kendaraan_cam',['id_user'=>$operator->id, 'id_camera'=>$camera->id])}}" title="Blank Page"><i class="icon-media-record"></i><span>{{ substr($camera->lokasi, 0, 22) }}</span></a>
                            </li>
                            @endforeach
                        </ul>
                    </li>

                    <li>
                        <a class="tooltip-tip " href="{{ route('pelanggaran', $operator->id) }}" title="login">
                            <i class="icon-document-new"></i>
                            <span>Pelanggaran</span>
                        </a>
                    </li>

                    <li>
                        <a class="tooltip-tip " href="login.html" title="login">
                            <i class="icon-document-new"></i>
                            <span>Kemacetan</span>
                        </a>
                    </li>


                </ul>

                <ul class="topnav menu-left-nest">
                    <li>
                        <a href="#" style="border-left:0px solid!important;" class="title-menu-left">

                            <span class="">Menu GIS</span>
                            <i data-toggle="tooltip" class="entypo-cog pull-right config-wrap"></i>

                        </a>
                    </li>


                    <li>
                        <a class="tooltip-tip " href="{{ route('korlantas_gis', $operator->id) }}" title="login">
                            <i class="icon-document-new"></i>
                            <span>GIS</span>
                        </a>
                    </li>

                </ul>
                
            </div>
        </div>
    </div>
</div>
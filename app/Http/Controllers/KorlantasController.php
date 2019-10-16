<?php

namespace App\Http\Controllers;

use Charts;
use App\Anomali;
use App\User;
use App\Camera;
use App\CountingRekap;
use App\Speed;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class KorlantasController extends Controller
{
    //

    public function index()
    {
        #$cameras = Camera::where('user_id', Auth::user()->id)->get();

        $operators = User::where('type', 'operator')->withCount('punyaKamera')->get();
        return view('page.korlantas.page_index', compact('operators'))
            ->with('page', 'Dashboard');
    }

    public function data_day($cam_id, $day, $vehicle)
    {
        for ($x = 1; $x <= $day; $x++) {
            //echo $x;
            $date_fix = Carbon::today()->subDays($x)->toDateString();
            $data = CountingRekap::where('camera_id', $cam_id)
                ->where('vehicle', '=', $vehicle)
                ->where('created_at', '>=', $date_fix)
                ->orderBy('created_at', 'asc')->pluck('total');
        }

        $data_14 = CountingRekap::where('camera_id', $cam_id)
            ->groupBy('created_at')
            ->orderBy('created_at', 'dsc')
            ->take(14)->get();

        foreach ($data_14 as $row) {
            $data = CountingRekap::where('camera_id', $cam_id)
                ->where('vehicle', '=', $vehicle)
                ->where('created_at', '>=', $date_fix)
                ->orderBy('created_at', 'asc')->get();
        }

        return $data;
    }

    public function view_volume_kendaraan($id)
    {

        $cameras = Camera::where('user_id', $id)->get();

        $camera = Camera::find($id);

        //return $camera;

        return view('page.korlantas.page_index', compact('camera', 'cameras'))
            ->with('page', 'Keterangan');
    }

    public function view_volume_kendaraan_id($id)
    {
        //$operator = User::where('camera_id', $id)->first();
        //$camera = Camera::find($id)->get();
        // return $id;
        // return $camera;

        $cameras = Camera::where('user_id', $id)->get();
        $operator = User::find($id);
        $random_camera = Camera::orderByRaw("RAND()")->first();
        $data_camera = CountingRekap::orderBy('created_at', 'dsc')->take(2)->get();

        return view('page.korlantas.page_view_volume_kendaraan', compact('cameras', 'operator', 'random_camera', 'data_camera'))
            ->with('page', 'Keterangan');
    }

    public function get_date($cam_id)
    {
        $data_14 = CountingRekap::where('camera_id', $cam_id)
            ->groupBy('created_at')
            ->orderBy('created_at', 'dsc')
            ->where('vehicle', 'mobil')
            ->take(14)->get();

        #return $data_14;

        $dates = $data_14->pluck('created_at');
        #$sortedDates = collect($data_14)->sortBy('created_at')->all();
        #$dates = $data_14->pluck('created_at');
        #$sortedDates = collect($dates)->sortBy('date')->all();

        $formattedDates = $dates->map(function ($date) {
            return $date;
        });

        return $formattedDates;
    }

    public function get_data_bydate($cam_id, $date, $vehicle)
    {
        $data = CountingRekap::where('camera_id', $cam_id)
            ->where('vehicle', '=', $vehicle)
            ->where('created_at', '>=', $date)
            ->orderBy('created_at', 'dsc')->pluck('total');

        return $data;
    }

    public function view_volume_kendaraan_cam($id_user, $id_camera)
    {
        $cameras = Camera::where('user_id', $id_user)->get();
        $operator = User::find($id_user);
        $selected_camera = Camera::find($id_camera);
        $data_camera = CountingRekap::where('camera_id', $id_camera)->orderBy('created_at', 'dsc')->take(200)->get();

        $categorys = $this->get_date($id_camera);

        #return $categorys;

        //$data_motor = $this->data_day($id_camera, 14, 'motor')->pluck('total');
        //$data_mobil = $this->data_day($id_camera, 14, 'mobil')->pluck('total');
        //$data_bus_truk = $this->data_day($id_camera, 14, 'bus_truk')->pluck('total');

        foreach($categorys as $category){
            $data_motor = $this->get_data_bydate($id_camera, $category, 'motor');
            $data_mobil = $this->get_data_bydate($id_camera, $category, 'mobil');
            $data_bus_truk = $this->get_data_bydate($id_camera, $category, 'bus_truk');

            $dada = $this->get_data_bydate($id_camera, $category, 'mobil');

            $cat[] = $category->format('d, M Y');
            #echo $category;
        }

        //return $dada;

        $chart = Charts::multi('bar', 'highcharts')
            ->labels($categorys)
            ->title('Jumlah Kendaraan - ' . $selected_camera->lokasi)
            ->elementLabel('Jumlah Kendaraan')
            ->dataset('Mobil', $data_mobil)
            ->dataset('Motor', $data_motor)
            ->dataset('Truk/Bus', $data_bus_truk);

        //return $data_motor;
        //return $categorys;

        //return $camera;
        return view(
            'page.korlantas.page_view_volume_kendaraan_cam',
            compact('cameras', 'operator', 'selected_camera', 'data_camera', 'data_motor', 'data_mobil', 'data_bus_truk', 'categorys', 'chart')
        )
            ->with('page', 'Keterangan');
    }

    public function index_view_volume($id)
    {
        $cameras = Camera::where('user_id', $id)->get();
        $operator = User::find($id);

        //return $cameras;

        /*
        $data_camera = CountingRekap::orderBy('created_at', 'dsc')->get();
        $data_speed = Speed::orderBy('created_at', 'dsc')->get();

        $data = DB::table('counting_rekap')
            ->select('camera_id', DB::raw('SUM(total)'))
            ->groupBy('camera_id')
            ->get();

        foreach ($data as $key => $value) {
            $val_chart[] = Camera::find($value->camera_id)->lokasi;
        }

        //return $data_camera;


        $chart = Charts::create('bar', 'highcharts')
            ->title('Jumlah Kendaraan Keseluruhan - ' . $operator->name)
            ->elementLabel('Jumlah Kendaraan')
            ->labels($val_chart)
            ->values($data->pluck('SUM(total)'))
            ->responsive(true);

        //chart speed
        $data_speed_chart = Speed::take(14)->orderBy('created_at', 'dsc')->get();
        $dates_speed = $data_speed_chart->pluck('created_at');
        $formatted_dates_speed = $dates_speed->map(function ($date) {
            return $date->format('d, M Y');
        });

        //return $data_speed_chart;

        $chart_speed = Charts::create('bar', 'highcharts')
            ->title('Kecepatan Rata-rata Kendaraan Keseluruhan')
            ->elementLabel('kecepatan Kendaraan')
            ->labels($formatted_dates_speed)
            ->values($data_speed_chart->pluck('speed'))
            ->responsive(true);
        */

        return view(
            'page.korlantas.page_index_view_volume',
            compact('cameras', 'operator')
        )
            ->with('page', 'Keterangan');
    }

    public function view_speed_kendaraan_cam($id_user, $id_camera)
    {
        $cameras = Camera::where('user_id', $id_user)->get();
        $operator = User::find($id_user);
        $selected_camera = Camera::find($id_camera);
        $data_camera_dsc = Speed::where('camera_id', $id_camera)->orderBy('created_at', 'dsc')->get();

        $data_camera = Speed::where('camera_id', $id_camera)
            ->take(14)
            ->orderBy('created_at', 'asc')
            ->get();

        $dates = $data_camera->pluck('created_at');

        $formattedDates = $dates->map(function ($date) {
            return $date->format('d, M Y');
        });

        $chart = Charts::create('bar', 'highcharts')
            ->title('Kecepatan Rata-rata - ' . $operator->name)
            ->elementLabel('Kecepatan Kendaraan')
            ->labels($formattedDates)
            ->values($data_camera->pluck('speed'))
            ->responsive(true);

        /*
        $data = Speed::where('camera_id', $id_camera)
            ->take(14)
            ->orderBy('created_at', 'dsc')
            ->get();

        //return $data;

        foreach ($data as $key => $value) {
            $val_chart[] = Camera::find($value->camera_id)->lokasi;
        }

        $chart = Charts::create('bar', 'highcharts')
			->title('Kecepatan Rata-rata - '.$operator->name)
			->elementLabel('Kecepatan Kendaraan')
			->labels($val_chart)
			->values($data->pluck('speed'))
            ->responsive(true);
        */

        return view('page.korlantas.page_view_speed_kendaraan_cam', compact('cameras', 'operator', 'selected_camera', 'data_camera_dsc', 'chart'))
            ->with('page', 'Keterangan');
    }

    public function view_display($id_user)
    {
        $cameras = Camera::where('user_id', $id_user)->get();
        $cameras_random = Camera::where('user_id', $id_user)->inRandomOrder()->take(2)->get();

        //return $cameras_random;

        return view('page.korlantas.page_view_display', compact('cameras_random', 'cameras'))
            ->with('page', 'Viewer');
    }

    public function pelanggaran($id_user)
    {
        $pelanggaran = Anomali::all()->sortByDesc("created_at")->take(200);
        $operator = User::find($id_user);
        $cameras = Camera::where('user_id', $id_user)->get();

        return view('page.korlantas.page_pelanggaran', compact('cameras', 'pelanggaran', 'operator'))
            ->with('page', 'Pelanggaran');
    }

    public function korlantas_gis($id_user)
    {
        $operator = User::find($id_user);
        $cameras = Camera::where('user_id', $id_user)->get();

        return view('page.korlantas.page_gis', compact('operator', 'cameras'))
            ->with('page', 'GIS');
    }
}

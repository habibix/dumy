<?php

namespace App\Http\Controllers;

use App\Anomali;
use App\User;
use App\Camera;
use App\Charts\AnomaliChart;
use App\Charts\SpeedChart;
use App\Charts\VolumeChart;
use App\CountingRekap;
use App\CountRecord;
use App\Speed;
use App\SpeedRecord;
use DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class KorlantasController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function hour_label()
    {
        $hour_label = collect([]);

        for ($i = 0; $i <= 24; $i++) {
            $hour_label->push($i . ":00");
        }

        return $hour_label;
    }

    public function index()
    {
        #$cameras = Camera::where('user_id', Auth::user()->id)->get();

        $operators = User::where('type', 'operator')->withCount('punyaKamera')->get();
        return view('page.korlantas.page_index', compact('operators'))
            ->with('page', 'Dashboard');
    }


    public function index_view_volume($id)
    {
        $cameras = Camera::where('user_id', $id)->get();
        $operator = User::find($id);

        return view(
            'page.korlantas.page_index_view_volume',
            compact('cameras', 'operator')
        )
            ->with('page', 'Keterangan');
    }

    public function view_count_kendaraan($id_user, $id_camera)
    {

        $cameras = Camera::where('user_id', $id_user)->get();
        $operator = User::find($id_user);
        $selected_camera = Camera::find($id_camera);
        $data_camera = CountingRekap::where('camera_id', $id_camera)->orderBy('created_at', 'dsc')->take(200)->get();

        $hour_label = collect([]);

        for ($i = 0; $i <= 24; $i++) {
            $hour_label->push($i . ":00");
        }


        $chart = new VolumeChart;
        $today = date("Y-m-d");
        $api = url('/get_data_volume/' . $today . '/' . $id_camera);
        $chart->labels($hour_label)->load($api);


        //return $today;

        return view(
            'page.korlantas.page_view_volume_kendaraan_cam',
            compact('cameras', 'operator', 'selected_camera', 'data_camera', 'chart', 'id_camera')
        )
            ->with('page', 'Keterangan');
    }

    public function chartApiDate($date, $id_camera)
    {
        $date_time = $date . ' 00:00:00';

        $data_mobil = collect([]);
        $data_motor = collect([]);
        $data_bus_truk = collect([]);

        for ($hour = 0; $hour <= 23; $hour++) {

            $data_mobil->push(CountRecord::where('created_at', '>=', Carbon::parse($date_time)->addHour($hour))
                ->where('created_at', '<=', Carbon::parse($date_time)->addHour($hour + 1))
                ->where('vehicle', 'mobil')
                ->where('camera_id', $id_camera)
                ->count());

            $data_motor->push(CountRecord::where('created_at', '>=', Carbon::parse($date_time)->addHour($hour))
                ->where('created_at', '<=', Carbon::parse($date_time)->addHour($hour + 1))
                ->where('vehicle', 'motor')
                ->where('camera_id', $id_camera)
                ->count());

            $data_bus_truk->push(CountRecord::where('created_at', '>=', Carbon::parse($date_time)->addHour($hour))
                ->where('created_at', '<=', Carbon::parse($date_time)->addHour($hour + 1))
                ->where('vehicle', 'bus_truk')
                ->where('camera_id', $id_camera)
                ->count());
        }

        $chart = new VolumeChart;
        $chart->dataset('Mobil', 'line', $data_mobil);
        $chart->dataset('Motor', 'line', $data_motor);
        $chart->dataset('Bus/Truk', 'line', $data_bus_truk);

        return $chart->api();
    }

    public function view_speed_kendaraan_cam($id_user, $id_camera)
    {
        $cat = [];
        $data_speed = [];

        $cameras = Camera::where('user_id', $id_user)->get();
        $operator = User::find($id_user);
        $selected_camera = Camera::find($id_camera);
        $data_camera_dsc = Speed::where('camera_id', $id_camera)->orderBy('created_at', 'dsc')->get();

        //return $this->hour_label();

        $chart = new SpeedChart;
        $today = date("Y-m-d");
        $api = url('/get_data_speed/' . $today . '/' . $id_camera);
        $chart->labels($this->hour_label())->load($api);

        return view('page.korlantas.page_view_speed_kendaraan_cam', compact('cameras', 'operator', 'selected_camera', 'data_camera_dsc', 'chart'))
            ->with('page', 'Keterangan');
    }

    public function chart_api_speed($date, $id_camera)
    {
        $date_time = $date . ' 00:00:00';

        $speed = collect([]);

        for ($hour = 0; $hour <= 23; $hour++) {

            $avg_speed = SpeedRecord::where('created_at', '>=', Carbon::parse($date_time)->addHour($hour))
                ->where('created_at', '<=', Carbon::parse($date_time)->addHour($hour + 1))
                ->where('camera_id', $id_camera)
                ->avg('speed_record');

            $avg_speed = (int) $avg_speed;

            $speed->push($avg_speed);
        }

        $chart = new SpeedChart;
        $chart->dataset('Kecepatan', 'column', $speed);

        return $chart->api();
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
        //$cameras = Camera::where('user_id', $id_user)->get();
        $cameras = Camera::with('punya_pelanggaran')->where('user_id', $id_user)->get();
        $user = User::with('punyaKamera')->find($id_user);

        //chart
        $day_0 = Anomali::whereDate('created_at', today())->count();
        $day_1 = Anomali::whereDate('created_at', today()->subDays(1))->count();
        $day_2 = Anomali::whereDate('created_at', today()->subDays(2))->count();
        $day_3 = Anomali::whereDate('created_at', today()->subDays(3))->count();
        $day_4 = Anomali::whereDate('created_at', today()->subDays(4))->count();
        $day_5 = Anomali::whereDate('created_at', today()->subDays(5))->count();
        $day_6 = Anomali::whereDate('created_at', today()->subDays(6))->count();
        $day_7 = Anomali::whereDate('created_at', today()->subDays(7))->count();

        $chart = new AnomaliChart;
        #$chart->labels("pelangaran, 1, 3,4");
        #$chart->dataset('Pelanggaran', 'column', [1, 2, 3, 4]);
        $chart->labels([
            today()->subDays(7)->toFormattedDateString(),
            today()->subDays(6)->toFormattedDateString(),
            today()->subDays(5)->toFormattedDateString(),
            today()->subDays(4)->toFormattedDateString(),
            today()->subDays(3)->toFormattedDateString(),
            today()->subDays(2)->toFormattedDateString(),
            today()->subDays(1)->toFormattedDateString(),
            today()->toFormattedDateString()
        ]);
        $chart->dataset('Pelanggaran', 'column', [$day_7, $day_6, $day_5, $day_4, $day_3, $day_2, $day_1, $day_0]);

        $pelanggaran = collect([]);

        foreach ($cameras as $camera) {
            foreach ($camera['punya_pelanggaran'] as $pel) {
                $pelanggaran->push($pel);
            }
        }

        $chart = new AnomaliChart;
        $today = date("Y-m-d");
        $api = url('/get_data_anomali/' . $today . '/' . $id_user);
        $chart->labels($this->hour_label())->load($api);

        return view('page.korlantas.page_pelanggaran', compact('cameras', 'pelanggaran', 'operator', 'chart'))
            ->with('page', 'Pelanggaran');
    }

    public function chart_api_anomali($date, $id_user, $vehicle=null)
    {
        ini_set('memory_limit', '256M');
        $date_time = $date . ' 00:00:00';
        $anomali = collect([]);
        $cameras = collect([]);

        for ($hour = 0; $hour <= 23; $hour++) {

            $pelanggaran = collect([]);

            $date_time = $date . ' 00:00:00';
            $cameras = Camera::with(['punya_pelanggaran' => function ($q) use ($hour, $date_time, $vehicle) {
                $q->where('created_at', '>=', Carbon::parse($date_time)->addHour($hour))
                ->where('created_at', '<=', Carbon::parse($date_time)->addHour($hour + 1))
                ->where('anomali', 'LIKE', $vehicle);
            }])
                ->where('user_id', $id_user)->get();

            foreach ($cameras as $camera) {
                foreach ($camera['punya_pelanggaran'] as $pel) {
//                    $pel = count($pel);
                    //echo $hour."-".$pel."</br>";
                    $pelanggaran->push($pel);
                }
            }

            $anomali->push($pelanggaran->count());

            // echo $pelanggaran->count();
            // echo "</br></br></br></br>";
        }

        // return $anomali;
        // return $chart->api();

        // return $cameras;

        // foreach ($cameras as $camera) {
        //     foreach ($camera['punya_pelanggaran'] as $pel) {
        //         $pelanggaran->push($pel);
        //     }
        // }

        $chart = new AnomaliChart;
        $chart->dataset('Anomali', 'column', $anomali);

        return $chart->api();
    }

    public function korlantas_gis($id_user)
    {
        $operator = User::find($id_user);
        $cameras = Camera::where('user_id', $id_user)->get();

        return view('page.korlantas.page_gis', compact('operator', 'cameras'))
            ->with('page', 'GIS');
    }
}

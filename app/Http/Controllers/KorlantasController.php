<?php

namespace App\Http\Controllers;

use App\Anomali;
use App\AnomaliRekap;
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

        for ($i = 0; $i <= 23; $i++) {
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
        $date_label = collect([]);
        $max_hour = collect([]);
        $data_rekap = collect([]);
        

        for ($i = 0; $i <= 23; $i++) {
            $hour_label->push($i . ":00");
            $date_label->push($i . ":00:00");
        }
        
        //Order::where('created_at', '>=', Carbon::now()->startOfMonth())->get();

        foreach($date_label as $dtl){
            $max_hour = CountingRekap::where('created_at', '>=', Carbon::now()->startOfMonth())
                ->where('created_at', 'LIKE', '%'.$dtl)
                ->select('id','created_at', DB::raw('sum(total) as total_vehicle'))
                ->first();

            $data_rekap->push((int)$max_hour['total_vehicle']);
        }


        $chart = new VolumeChart;
        $today = date("Y-m-d");
        $api = url('/get_data_volume/' . $today . '/' . $id_camera);
        $chart->labels($hour_label)->load($api);

        $chart = new VolumeChart;
        $today = date("Y-m-d");
        $api = url('/get_data_volume/' . $today . '/' . $id_camera);
        $chart->labels($hour_label)->load($api);

        $chart_month = new VolumeChart;
        $chart_month->labels($hour_label);
        $chart_month->dataset('Volume Kendaraan', 'column', $data_rekap);


        //return $today;

        return view(
            'page.korlantas.page_view_volume_kendaraan_cam',
            compact('cameras', 'operator', 'selected_camera', 'data_camera', 'chart', 'id_camera', 'chart_month')
        )
            ->with('page', 'Keterangan');
    }

    public function chartApiDate($date, $id_camera, $vehicle=null)
    {
        $date_time = $date . ' 00:00:00';

        $data_mobil = collect([]);
        $data_motor = collect([]);
        $data_bus_truk = collect([]);

        for ($hour = 0; $hour <= 23; $hour++) {


            $mob = CountingRekap::where('camera_id', $id_camera)
            ->where('vehicle', 'mobil')
            ->where('created_at', Carbon::parse($date_time)->addHour($hour))
            ->first();

            $mot = CountingRekap::where('camera_id', $id_camera)
            ->where('vehicle', 'motor')
            ->where('created_at', Carbon::parse($date_time)->addHour($hour))
            ->first();

            $bus = CountingRekap::where('camera_id', $id_camera)
            ->where('vehicle', 'bus_truk')
            ->where('created_at', Carbon::parse($date_time)->addHour($hour))
            ->first();

            //return $mob;

            $data_mobil->push($mob['total'] > 0 ? $mob['total'] : 0);
            $data_motor->push($mot['total'] > 0 ? $mot['total'] : 0);
            $data_bus_truk->push($bus['total'] > 0 ? $bus['total'] : 0);

            //$data_mobil->push($cnt['total']);

        }

        //return $data_mobil;

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
        $data_camera_dsc = Speed::where('camera_id', $id_camera)->orderBy('created_at', 'dsc')->take(200)->get();

        //return $data_camera_dsc;

        $date_label = collect([]);
        $data_rekap_speed = collect([]);
        for ($i = 0; $i <= 23; $i++) {
            $date_label->push($i . ":00:00");
        }

        foreach($date_label as $dtl){
            $max_hour_speed = Speed::where('created_at', '>=', Carbon::now()->startOfMonth())
                ->where('created_at', 'LIKE', '%'.$dtl)
                ->select('id', 'created_at', DB::raw('avg(speed) as average_speed'))
                ->first();

            $data_rekap_speed->push((int)$max_hour_speed['average_speed']);
        }

        //return $data_rekap_speed;

        $chart_month = new VolumeChart;
        $chart_month->labels($this->hour_label());
        $chart_month->dataset('Volume Kendaraan', 'column', $data_rekap_speed);

        $chart = new SpeedChart;
        $today = date("Y-m-d");
        $api = url('/get_data_speed/' . $today . '/' . $id_camera);
        $chart->labels($this->hour_label())->load($api);

        return view('page.korlantas.page_view_speed_kendaraan_cam', compact('cameras', 'operator', 'selected_camera', 'data_camera_dsc', 'chart', 'chart_month'))
            ->with('page', 'Keterangan');
    }

    public function chart_api_speed($date, $id_camera, $vehicle=null)
    {
        $date_time = $date . ' 00:00:00';

        $speed = collect([]);

        for ($hour = 0; $hour <= 23; $hour++) {

            // $avg_speed = SpeedRecord::where('created_at', '>=', Carbon::parse($date_time)->addHour($hour))
            //     ->where('created_at', '<=', Carbon::parse($date_time)->addHour($hour + 1))
            //     ->where('camera_id', $id_camera)
            //     ->avg('speed_record');

            // $avg_speed = (int) $avg_speed;

            // $speed->push($avg_speed);

            $spd = Speed::where('camera_id', $id_camera)
            ->where('created_at', Carbon::parse($date_time)->addHour($hour))
            ->where('vehicle', 'LIKE', $vehicle)
            ->get()
            ->avg('speed');

            //echo $spd."<br>";

            $speed->push((int)$spd > 0 ? (int)$spd : 0);
        }

        //return $spd;

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
        $pelanggaran = Anomali::all()->sortByDesc("created_at")->take(500);
        $operator = User::find($id_user);
        // $cameras = Camera::with('punya_pelanggaran')->where('user_id', $id_user)->get();
        $cameras = [];
        $cameras = Camera::where('user_id', $id_user)->get();

        $chart = new AnomaliChart;
        $today = date("Y-m-d");
        $api = url('/get_data_anomali/' . $today . '/' . $id_user);
        $chart->labels($this->hour_label())->load($api);

        return view('page.korlantas.page_pelanggaran', compact('cameras', 'pelanggaran', 'operator', 'chart'))
            ->with('page', 'Pelanggaran');
    }

    public function chart_api_anomali($date, $id_user, $anomali_type = null)
    {
        ini_set('memory_limit', '256M');
        $date_time = $date . ' 00:00:00';
        $anomali = collect([]);
        $cameras = collect([]);

        for ($hour = 0; $hour <= 23; $hour++) {

            $ano = AnomaliRekap::where('user_id', $id_user)
            ->where('created_at', Carbon::parse($date_time)->addHour($hour))
            ->where('anomali_type', 'LIKE', $anomali_type)
            ->take(500)
            ->sum('total');

            $anomali->push($ano);

        }

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

    public function kemacetan($id_user){
        $macet = Anomali::where('anomali', 'like', 'kemacetan')->where('user_id', $id_user)->take(500)->get();

        // return $macet;
        
        $operator = User::find($id_user);
        $cameras = Camera::where('user_id', $id_user)->get();

        $chart = new AnomaliChart;
        $today = date("Y-m-d");
        // http://127.0.0.1:8000/get_data_anomali/2019-12-08/5/melintas_bahu_jalan
        $api = url('/get_data_anomali/' . $today . '/' . $id_user. '/kemacetan');
        $chart->labels($this->hour_label())->load($api);

        // return $api;

        // $chart = new AnomaliChart;
        // $chart->labels(['One', 'Two', 'Three', 'Four']);
        // $chart->dataset('My dataset', 'line', [1, 2, 3, 4]);
        // $chart->dataset('My dataset 2', 'line', [4, 3, 2, 1]);

        return view('page.korlantas.page_macet', compact('macet', 'operator', 'cameras', 'chart'))
        ->with('page', 'Kemacetan');
    }

    public function kemacetan_api(){

    }
}

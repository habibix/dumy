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

    public function index()
    {
        #$cameras = Camera::where('user_id', Auth::user()->id)->get();

        $operators = User::where('type', 'operator')->withCount('punyaKamera')->get();
        return view('page.korlantas.page_index', compact('operators'))
            ->with('page', 'Dashboard');
    }

    public function view_count_kendaraan($id_user, $id_camera)
    {

        $cameras = Camera::where('user_id', $id_user)->get();
        $operator = User::find($id_user);
        $selected_camera = Camera::find($id_camera);
        $data_camera = CountingRekap::where('camera_id', $id_camera)->orderBy('created_at', 'dsc')->take(200)->get();

        $data_motor = [];
        $data_mobil = [];
        $data_bus_truk = [];
        $cat = [];

        for ($i = 0; $i <= 23; $i++) {
            //$hour[] = $i . ':00';
            $hour = collect([1, 2, 3]);
        }

        //return $hour;

        $data_motor = DB::table('count_record')
            ->select(DB::raw('count(*) as count, created_at, HOUR(created_at) as hour'))
            ->where('vehicle', 'motor')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->groupBy('hour')
            ->get();

        $data_mobil = DB::table('count_record')
            ->select(DB::raw('count(*) as count, created_at, HOUR(created_at) as hour'))
            ->where('vehicle', 'mobil')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->groupBy('hour')
            ->get();

        $data_bus_truk = DB::table('count_record')
            ->select(DB::raw('count(*) as count, created_at, HOUR(created_at) as hour'))
            ->where('vehicle', 'bus_truk')
            ->whereDate('created_at', '=', Carbon::now()->toDateString())
            ->groupBy('hour')
            ->get();


        $chart = new VolumeChart;
        $today = date("d-m-Y");
        $api = url('/test_data/' . $today.'/'.$id_camera);
        //$chart->labels($hour);
        $chart->labels($data_mobil->pluck('hour'))->load($api);


        //return view('sample_view', compact('chart'));

        return view(
            'page.korlantas.page_view_volume_kendaraan_cam',
            compact('cameras', 'operator', 'selected_camera', 'data_camera', 'data_motor', 'data_mobil', 'data_bus_truk', 'chart', 'id_camera')
        )
            ->with('page', 'Keterangan');
    }

    public function chartApiDate($date, $id_camera)
    {

        $date = Carbon::parse($date);

        $data_motor = [];
        $data_mobil = [];
        $data_bus_truk = [];
        $cat = [];

        $data_motor = DB::table('count_record')
            ->select(DB::raw('count(*) as count, created_at, HOUR(created_at) as hour'))
            ->where('vehicle', 'motor')
            ->where('camera_id', $id_camera)
            ->whereDate('created_at', '=', $date)
            ->groupBy('hour')
            ->get();

        $data_mobil = DB::table('count_record')
            ->select(DB::raw('count(*) as count, created_at, HOUR(created_at) as hour'))
            ->where('vehicle', 'mobil')
            ->where('camera_id', $id_camera)
            ->whereDate('created_at', '=', $date)
            ->groupBy('hour')
            ->get();

        $data_bus_truk = DB::table('count_record')
            ->select(DB::raw('count(*) as count, created_at, HOUR(created_at) as hour'))
            ->where('vehicle', 'bus_truk')
            ->where('camera_id', $id_camera)
            ->whereDate('created_at', '=', $date)
            ->groupBy('hour')
            ->get();


        $chart = new VolumeChart;
        $chart->dataset('Mobil', 'line', $data_mobil->pluck('count'));
        $chart->dataset('Motor', 'line', $data_motor->pluck('count'));
        $chart->dataset('Bus/Truk', 'line', $data_bus_truk->pluck('count'));

        //$data_mo = collect([]); // Could also be an array

        for ($days_backwards = 23; $days_backwards >= 0; $days_backwards--) {
            // Could also be an array_push if using an array rather than a collection.
            //$data_mo->push(User::whereDate('created_at', '>=', Carbon::now()->subHour($days_backwards))->count());
            $data_mo[] = today()->subHour($days_backwards);
            // $data_mo[] = CountRecord::whereDate('created_at', '>=' , today()->subHour($days_backwards))
            // ->whereDate('created_at', '>' , today()->subDay(1))
            // ->where('vehicle', 'bus_truk')->count();
        }

        //return $data_mo;

        return $chart->api();
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

    public function view_speed_kendaraan_cam($id_user, $id_camera)
    {
        $cat = [];
        $data_speed = [];

        $cameras = Camera::where('user_id', $id_user)->get();
        $operator = User::find($id_user);
        $selected_camera = Camera::find($id_camera);
        $data_camera_dsc = Speed::where('camera_id', $id_camera)->orderBy('created_at', 'dsc')->get();

        $chart = new SpeedChart;
        $chart->labels($cat);
        $chart->dataset('Kecepatan Rata-rata', 'column', $data_speed);


        //chart
        $day_0 = Speed::whereDate('created_at', today())->count();
        $day_1 = Speed::whereDate('created_at', today()->subDays(1))->count();
        $day_2 = Speed::whereDate('created_at', today()->subDays(2))->count();
        $day_3 = Speed::whereDate('created_at', today()->subDays(3))->count();
        $day_4 = Speed::whereDate('created_at', today()->subDays(4))->count();
        $day_5 = Speed::whereDate('created_at', today()->subDays(5))->count();
        $day_6 = Speed::whereDate('created_at', today()->subDays(6))->count();

        $chart = new SpeedChart;
        $chart->labels([
            today()->subDays(6)->toFormattedDateString(),
            today()->subDays(5)->toFormattedDateString(),
            today()->subDays(4)->toFormattedDateString(),
            today()->subDays(3)->toFormattedDateString(),
            today()->subDays(2)->toFormattedDateString(),
            today()->subDays(1)->toFormattedDateString(),
            today()->toFormattedDateString()
        ]);
        $chart->dataset('kecepatan', 'column', [$day_6, $day_5, $day_4, $day_3, $day_2, $day_1, $day_0]);


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

        return view('page.korlantas.page_pelanggaran', compact('cameras', 'pelanggaran', 'operator', 'chart'))
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

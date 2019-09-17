<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Charts;
use Auth;
use DB;
use App\Counting;
use App\Anomali;
use App\Camera;
use App\CountingRekap;
use App\User;
use App\Speed;
use App\Logs;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class OperatorController extends Controller
{

	protected $day = 14;

	public function __construct() {
		$this->middleware('auth');
	}

	public function data_day($cam_id, $day, $vehicle){
		for ($x = 1; $x <= $day; $x++) {
			//echo $x;
			$date_fix = Carbon::today()->subDays($x)->toDateString();
			$data = CountingRekap::where('camera_id', $cam_id)
				->where( 'vehicle', '=', $vehicle)
				->where( 'created_at', '>=', $date_fix)
				->orderBy('created_at','asc')->pluck('total');
		}

		return $data;
	}

	public function data_speed_day($cam_id, $day){
		$days[] = '';
		for ($x = 1; $x <= $day; $x++) {
			//echo $x;
			$date_fix = Carbon::today()->subDays($x)->toDateString();
			$data = Speed::where('camera_id', $cam_id)
				->where( 'created_at', '>=', $date_fix)
				->orderBy('created_at','asc')->pluck('speed');
		}

		return $data;
	}

	public function index(){
		$count_rekap = CountingRekap::all();
		$camera = Camera::where('user_id', Auth::user()->id)->get();
		$series[] = [];
		$day = 14;
		$cam_id = 1;

		//return $this->data_day(1, 14, 'mobil');

		$now = Carbon::now();
		$xAxis = [];
		for ($i=$day; $i >= 0; $i--) {
			$xAxis[] = Carbon::today()->subDays($i)->format('D, d M Y');;
		}

		//return $xAxis;

		$chart_line = Charts::multi('line', 'highcharts')
		    ->labels($xAxis)
		    ->title('Jumlah Kendaraan Camera 1')
		    ->elementLabel('Jumlah Kendaraan')
		    ->dataset('Mobil', $this->data_day(1, 14, 'mobil'))
		    ->dataset('Motor', $this->data_day(1, 14, 'motor'))
		    ->dataset('Truk/Bus', $this->data_day(1, 14, 'truk/bus'));

		$chart_speed = Charts::multi('line', 'highcharts')
		    ->labels($xAxis)
		    ->title('Kecepatan Rata-rata Kendaraan')
		    ->elementLabel('Kecepatan KM/H')
		    ->dataset('Average Speed', $this->data_speed_day(1, 14));

		$avg_speed = Speed::avg('speed');

		return view('page.operator.page_index')
			->with('xAxis', $xAxis)
			->with('series', $series)
			->with('chart', $chart_line)
			->with('speed_chart', $chart_speed)
			->with('camera', $camera)
			->with('avg_speed', $avg_speed)
			->with('count_rekap', $count_rekap)
			->with('page', 'Dashboard');
	}

	public function counting_page(){

		$camera = Camera::where('user_id', Auth::user()->id)->get();
		$count_rekap = CountingRekap::all();
		$chart = Charts::database(CountingRekap::all(), 'bar', 'highcharts');

		//$data2 = CountingRekap::with('camera')->get();

		$data = DB::table('counting_rekap')
			    ->select('camera_id', DB::raw('SUM(total)'))
			    ->groupBy('camera_id')
			    ->get();

		foreach ($data as $key => $value) {
			$val_chart[] = Camera::find($value->camera_id)->lokasi;
		}

		//return Camera::find(1)->lokasi;

		//return $users = CountingRekap::groupBy('camera_id')->get();
		$chart = Charts::create('line', 'highcharts')
		             ->title('Jumlah Kendaraan Keseluruhan')
		             ->elementLabel('Jumlah Kendaraan')
		             ->labels($val_chart)
		             ->values($data->pluck('SUM(total)'))
		             ->responsive(true);

		return view('page.operator.page_counting', compact('camera', 'chart', 'count_rekap'))
			->with('page', 'Analisa Perhitungan');
	}

	public function counting_page_id($id){
		$count_rekap = CountingRekap::all();
		$series[] = [];
		$day = 14;
		$camera = Camera::where('user_id', Auth::user()->id)->get();
		$active_camera = Camera::find($id);

		$now = Carbon::now();
		$xAxis = [];
		for ($i=$day; $i >= 0; $i--) {
			$xAxis[] = Carbon::today()->subDays($i)->format('D, d M Y');;
		}


		$chart_line = Charts::multi('line', 'highcharts')
		    ->labels($xAxis)
		    ->title('Jumlah Kendaraan : '.$active_camera->lokasi)
		    ->elementLabel('Jumlah Kendaraan')
		    ->dataset('Mobil', $this->data_day($id, 14, 'mobil'))
		    ->dataset('Motor', $this->data_day($id, 14, 'motor'))
		    ->dataset('Truk/Bus', $this->data_day($id, 14, 'bus/truk'));

		return view('page.operator.page_counting_id')
			->with('xAxis', $xAxis)
			->with('chart', $chart_line)
			->with('camera', $camera)
			->with('active_camera', $active_camera)
			->with('count_rekap', $count_rekap)
			->with('page', 'Analisa Perhitungan');
	}

	public function speed_page(){
		$day = 14;
		$camera = Camera::where('user_id', Auth::user()->id)->get();
		$speed = Speed::all();

		$now = Carbon::now();

		$xAxis = [];
		for ($i=$day; $i >= 0; $i--) {
			$xAxis[] = Carbon::today()->subDays($i)->format('D, d M Y');;
		}

		$chart = Charts::multi('line', 'highcharts')
		    ->labels($xAxis)
		    ->title('Kecepatan Rata-rata Kendaraan')
		    ->elementLabel('Kecepatan KM/H')
		    ->dataset('Average Speed', $this->data_speed_day(1, 14));

		$avg_speed = Speed::avg('speed');

		return view('page.operator.page_speed', compact('chart', 'avg_speed', 'camera', 'speed'))
			->with('page', 'Analisa Kecepatan');
	}

	public function speed_page_id($id){
		$avg_speed = 0;
		$day = 14;
		$camera = Camera::where('user_id', Auth::user()->id)->get();
		$active_camera = Camera::find($id);
		$now = Carbon::now();

		$xAxis = [];
		for ($i=$day; $i >= 0; $i--) {
			$xAxis[] = Carbon::today()->subDays($i)->format('D, d M Y');;
		}

		$chart = Charts::multi('line', 'highcharts')
		    ->labels($xAxis)
		    ->title('Kecepatan Rata-rata Kendaraan : '.$active_camera->lokasi)
		    ->elementLabel('Kecepatan KM/H')
		    ->dataset('Average Speed', $this->data_speed_day($id, 14));

		if(Speed::find($id)){
			$avg_speed = Speed::find($id)->avg('speed');
		}

		return view('page.operator.page_speed_id', compact('camera', 'avg_speed', 'chart', 'active_camera'))
			->with('page', 'Counting');
	}

	public function gis_page(){
		return view('page.operator.gis2');
	}

	//API CHART
	public function chartCounting($id) {
		$now = Carbon::now();
		$xAxis = [];
		for ($i=$this->day; $i >= 0; $i--) {
			$xAxis[] = Carbon::today()->subDays($i)->format('D, d M Y');;
		}

	    $chart_line = Charts::multi('line', 'highcharts')
		    ->labels($xAxis)
		    ->title('Jumlah Kendaraan Camera')
		    ->elementLabel('Jumlah Kendaraan')
		    ->dataset('Mobil', $this->data_day($id, 14, 'mobil'))
		    ->dataset('Motor', $this->data_day($id, 14, 'motor'))
		    ->dataset('Truk/Bus', $this->data_day($id, 14, 'truk/bus'));

	    return response()->json($chart_line);
	}

	public function anomali(){

		$anomali = Anomali::all();

		return view('page.operator.page_anomali')
			->with('anomali', $anomali)
			->with('page', 'Pelanggaran');
	}

}

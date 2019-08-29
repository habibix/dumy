<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Charts;
use Auth;
use App\Counting;
use App\Camera;
use App\CountingRekap;
use App\User;
use App\Speed;
use App\Logs;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class OperatorController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

	public function data_day($cam_id, $day, $vehicle){
		$days[] = '';
		$cam_id = 1;
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
		$cam_id = 1;
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
		$camera = Camera::all();
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

		return view('page.operator.index')
			->with('xAxis', $xAxis)
			->with('series', $series)
			->with('chart', $chart_line)
			->with('speed_chart', $chart_speed)
			->with('camera', $camera)
			->with('avg_speed', $avg_speed)
			->with('count_rekap', $count_rekap);
	}

	public function counting_page()
	{
		$count_rekap = CountingRekap::all();
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

		return view('page.operator.counting')
			->with('xAxis', $xAxis)
			->with('series', $series)
			->with('chart', $chart_line)
			->with('count_rekap', $count_rekap);
	}

	public function speed_page(){
		$day = 14;
		$cam_id = 1;
		$speed = Speed::all();

		$now = Carbon::now();

		$xAxis = [];
		for ($i=$day; $i >= 0; $i--) {
			$xAxis[] = Carbon::today()->subDays($i)->format('D, d M Y');;
		}

		$chart_speed = Charts::multi('line', 'highcharts')
		    ->labels($xAxis)
		    ->title('Kecepatan Rata-rata Kendaraan')
		    ->elementLabel('Kecepatan KM/H')
		    ->dataset('Average Speed', $this->data_speed_day(1, 14));

		$avg_speed = Speed::avg('speed');

		return view('page.operator.speed')
			->with('xAxis', $xAxis)
			->with('speed_chart', $chart_speed)
			->with('speed', $speed)
			->with('avg_speed', $avg_speed);
	}

	public function gis_page(){
		return view('page.operator.gis2');
	}

}

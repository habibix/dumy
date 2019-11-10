<?php

use Illuminate\Database\Seeder;
use App\CountingRekap;
use Carbon\Carbon;

class CountRekapSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $camera = ["1"];

        $date = new Carbon('2019-11-10 00:00:00');
        //$now = new Carbon('2019-08-29 00:00:00');

        foreach ($camera as $key => $value) {
        	for ($i=0; $i < 24; $i++) {
				$now_add = Carbon::parse($date)->addhour($i);
	        	$rekap = new CountingRekap;
	        	$rekap->total = rand(10000,20000);
	        	$rekap->camera_id = $value;
	        	$rekap->vehicle = 'motor';
	        	$rekap->created_at = $now_add;
	        	$rekap->save();
	        }

	        for ($i=0; $i < 24; $i++) {
				$now_add = Carbon::parse($date)->addhour($i);
	        	$rekap = new CountingRekap;
	        	$rekap->total = rand(100000,200000);
	        	$rekap->camera_id = $value;
	        	$rekap->vehicle = 'mobil';
	        	$rekap->created_at = $now_add;
	        	$rekap->save();
	        }

	        for ($i=0; $i < 24; $i++) {
				$now_add = Carbon::parse($date)->addhour($i);
	        	$rekap = new CountingRekap;
	        	$rekap->total = rand(1000,2000);
	        	$rekap->camera_id = $value;
	        	$rekap->vehicle = 'bus_truk';
	        	$rekap->created_at = $now_add;
	        	$rekap->save();
	        }

        }
    }
}

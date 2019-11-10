<?php

use Illuminate\Database\Seeder;
use App\Speed;
use App\SpeedRecord;
use Carbon\Carbon;

class SpeedSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $camera = 1;
        $date = new Carbon('2019-11-06 00:00:00');
        $vehicle = ['mobil', 'motor', 'bus_truk'];

        // foreach ($camera as $key => $value) {
        // 	for ($i=0; $i < 24; $i++) {
	    //     	$rekap = new SpeedRecord();
	    //     	$rekap->speed_record = rand(70, 110);
	    //     	$rekap->camera_id = $value;
	    //     	$rekap->created_at = Carbon::today()->addhour($i);
	    //     	$rekap->save();
	    //     }
        // }

        foreach ($vehicle as $key => $value) {
        	for ($i=0; $i < 24; $i++) {
                $now_add = Carbon::parse($date)->addhour($i);
                $rekap = new Speed();
                $rekap->speed = rand(80, 100);
	        	$rekap->vehicle = $value;
	        	$rekap->camera_id = $camera;
	        	$rekap->created_at = $now_add;
	        	$rekap->save();
	        }
        }
    }
}

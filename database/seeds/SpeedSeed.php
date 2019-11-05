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
        $camera = ["1"];

        $now = Carbon::now();
        //$now = new Carbon('2019-08-29 00:00:00');

        foreach ($camera as $key => $value) {
        	for ($i=0; $i < 24; $i++) {
	        	$rekap = new SpeedRecord();
	        	$rekap->speed_record = rand(70, 110);
	        	$rekap->camera_id = $value;
	        	$rekap->created_at = Carbon::today()->addhour($i);
	        	$rekap->save();
	        }
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use App\Speed;
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
        $camera = ["1", "2", "3", "4"];

        $now = Carbon::now();
        //$now = new Carbon('2019-08-29 00:00:00');

        foreach ($camera as $key => $value) {
        	for ($i=0; $i < 14; $i++) {
	        	$rekap = new Speed;
	        	$rekap->speed = rand(70, 110);
	        	$rekap->camera_id = $value;
	        	$rekap->created_at = Carbon::today()->subDays($i);
	        	$rekap->save();
	        }
        }
    }
}

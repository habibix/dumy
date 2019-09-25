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
        $camera = ["1", "2", "3", "4"];

        $now = Carbon::now();
        //$now = new Carbon('2019-08-29 00:00:00');

        foreach ($camera as $key => $value) {
        	for ($i=0; $i < 14; $i++) {
	        	$rekap = new CountingRekap;
	        	$rekap->total = rand(10000,20000);
	        	$rekap->camera_id = $value;
	        	$rekap->vehicle = 'motor';
	        	$rekap->created_at = Carbon::today()->subDays($i);
	        	$rekap->save();
	        }

	        for ($i=0; $i < 14; $i++) {
	        	$rekap = new CountingRekap;
	        	$rekap->total = rand(10000,20000);
	        	$rekap->camera_id = $value;
	        	$rekap->vehicle = 'mobil';
	        	$rekap->created_at = Carbon::today()->subDays($i);
	        	$rekap->save();
	        }

	        for ($i=0; $i < 14; $i++) {
	        	$rekap = new CountingRekap;
	        	$rekap->total = rand(10000,20000);
	        	$rekap->camera_id = $value;
	        	$rekap->vehicle = 'bus-truk';
	        	$rekap->created_at = Carbon::today()->subDays($i);
	        	$rekap->save();
	        }

        }
    }
}

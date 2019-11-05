<?php

use App\CountRecord;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CountRecordSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $camera = "1";
        $vehicle = ["mobil"];
        $date = new Carbon('2019-11-1 00:00:00');

        foreach($vehicle as $v){
            for ($i=0; $i < 24; $i++) {
                $now_add = Carbon::parse($date)->addhour($i)->addMinute($i+$i);
                $rekap = new CountRecord();
                $rekap->dimensi = rand(2000,20000);
                $rekap->camera_id = $camera;
                $rekap->vehicle = $v;
                $rekap->created_at = $now_add;
                $rekap->save();
            }
        }
    }
}

<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Anomali;

class AnomaliSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $camera = "2";
        $anomali = ["Melintas Bahu Jalan", "Melanggar Batas kecepatan"];
        $date = new Carbon('2019-11-4 00:00:00');

        foreach($anomali as $v){
            for ($i=0; $i < 24; $i++) {
                $now_add = Carbon::parse($date)->addhour($i)->addMinute($i+$i);
                $rekap = new Anomali();
                $rekap->anomali = $v;
                $rekap->camera_id = $camera;
                $rekap->image = $i.$v."_mamam3.jpg";
                $rekap->video = "NULL";
                $rekap->lpr = "NULL";
                $rekap->lpr_image = "NULL";
                $rekap->created_at = $now_add;
                $rekap->updated_at = $now_add;
                $rekap->save();
            }
        }
    }
}

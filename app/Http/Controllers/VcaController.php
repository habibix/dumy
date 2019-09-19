<?php

namespace App\Http\Controllers;

use App\Anomali;
use Illuminate\Http\Request;
use App\CountingRekap;
use App\Speed;
use App\Camera;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VcaController extends Controller
{
    public function insert_counting($camera_id, $vehicle)
    {
        $count_rekap = CountingRekap::where('camera_id', $camera_id)
        ->where('vehicle', $vehicle)
        ->whereDate('created_at', Carbon::today())->first();

        if ($count_rekap) {
            #add return $count_rekap;
            $inc = DB::table('counting_rekap')->where('id', $count_rekap['id'])->increment('total');
            return $inc;
            
        } else {
            $counting = new CountingRekap();
            $counting->total = 1;
            $counting->camera_id = $camera_id;
            $counting->vehicle = $vehicle;
            $counting->save();
            return "created";
        }
    }

    public function insert_speed($camera_id, $speed)
    {
        $count_speed = Speed::where('camera_id', $camera_id)
        ->whereDate('created_at', Carbon::today())->first();

        if ($count_speed) {
            #$inc = DB::table('speed')->where('id', $count_speed['id'])->increment('total');
            $count_speed->speed = $speed;
            $count_speed->save();
            return $count_speed;
            
        } else {
            $counting = new Speed();
            $counting->camera_id = $camera_id;
            $counting->speed = $speed;
            $counting->save();
            return "created";
        }
    }

    public function insert_anomali(Request $request){
        
        $anomali = new Anomali();
        $anomali->camera_id = $request->camera_id;
        $anomali->anomali = $request->anomali;
        $anomali->image = $request->image;
        $anomali->video = $request->video;
        $anomali->lpr = $request->lpr;
        $anomali->save();
    
        return $request;
    }

    public function get_data_stream($id){

        $camera = Camera::find($id);
        $speed = Speed::where('camera_id', $id);
        $count = CountingRekap::where('camera_id', $id)
        ->whereDate('created_at', Carbon::today())->first();;

        $data = [
            'stream_url'=> "ll",
            'total'=> $count
        ];

        return $data;
    }
}

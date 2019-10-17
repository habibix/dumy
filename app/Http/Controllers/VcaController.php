<?php

namespace App\Http\Controllers;

use App\Anomali;
use Illuminate\Http\Request;
use App\CountingRekap;
use App\Speed;
use App\Camera;
use App\CameraSetting;
use App\SpeedRecord;
use CountRekapSeeder;
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
        $anomali->lpr_image = $request->lpr_image;
        $anomali->save();
    
        return $request;
    }

    public function get_value_cam($id){

        $camera = Camera::find($id);
        $speed = Speed::where('camera_id', $id)->first();

        //kodingdiisini a
        $camera_detail = CameraSetting::where('camera_id', $id)->first();
        #$camera_detail = CameraSetting::all(9);

        //$coun = CountingRekap::all();
        
        $bus_truck = CountingRekap::where('camera_id', $id)
        ->where('vehicle', 'bus_truk')
        ->whereDate('created_at', Carbon::today())->first();

        $mobil = CountingRekap::where('camera_id', $id)
        ->where('vehicle', 'mobil')
        ->whereDate('created_at', Carbon::today())->first();

        $motor = CountingRekap::where('camera_id', $id)
        ->where('vehicle', 'motor')
        ->whereDate('created_at', Carbon::today())->first();

        // return $coun;

        
        
        $data = [

            'stream_url'=> $camera['rtsp_address'],
            'speed' => $speed['speed'],
            'bus_truk' => $bus_truck ? $bus_truck['total'] : 0,
            'mobil' => $mobil ? $mobil['total'] : 0,
            'motor' => $motor ? $motor['total'] : 0,
            'camera_detail' => $camera_detail
        ];

        return $data;
        return $camera_detail;
        
    }

    public function get_speed($id){
        $speed = Speed::where('camera_id', $id)->whereDate('created_at', Carbon::today())->first();

        $data = [
            'speed' => $speed ? $speed['speed'] : 0,
            'camera_id' => $speed ? $speed['camera_id'] : 0,
            'created_at' => $speed ? date_format($speed['created_at'], "Y/m/d H:i:s") : 0,
            'updated_at' => $speed ? date_format($speed['updated_at'], "Y/m/d H:i:s") : 0
        ];

        return $data;
    }

    public function connect_notif(){
        $notif = Anomali::where('notif', 0)
            ->where('created_at', '>', Carbon::now()->subMinutes(1)->toDateTimeString())
            ->orderBy('id', 'dsc')
            ->with(['camera'])
            ->first();
        if ($notif) {
            return $notif;
        } else {
            return [];
        }
        
    }

    public function release_notif($id){
        $notif = Anomali::where('id', $id)->update(array('notif' => '1'));
        return $notif;
    }

    public function insert_speedrecord(Request $request){
        $speed_record = new SpeedRecord();
        $speed_record->vehicle = $request->vehicle;
        $speed_record->speed_record = $request->speed_record;
        $speed_record->camera_id = $request->camera_id;
        $insert = $speed_record->save();
        
        if($insert){
            return "created";
        } else {
            return "failed";
        }
    }
}

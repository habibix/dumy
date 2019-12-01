<?php

namespace App\Http\Controllers;

use App\Anomali;
use App\AnomaliRekap;
use Illuminate\Http\Request;
use App\CountingRekap;
use App\Speed;
use App\Camera;
use App\CameraSetting;
use App\CountRecord;
use App\SpeedRecord;
use CountRekapSeeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VcaController extends Controller
{
    public function get_value_cam($id)
    {
        $data_mobil = collect([]);
        $data_motor = collect([]);
        $data_bus_truk = collect([]);

        $camera = Camera::find($id);
        $camera_detail = CameraSetting::where('camera_id', $id)->first();

        $data_mobil = CountingRekap::where('camera_id', $id)
            ->where('vehicle', 'mobil')
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        $data_motor = CountingRekap::where('camera_id', $id)
            ->where('vehicle', 'motor')
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        $data_bus_truk = CountingRekap::where('camera_id', $id)
            ->where('vehicle', 'bus_truk')
            ->whereDate('created_at', Carbon::today())
            ->sum('total');

        $data = [

            'stream_url' => $camera['rtsp_address'],
            'user_id' => $camera['user_id'],
            'bus_truk' => (int) $data_bus_truk,
            'mobil' => (int) $data_mobil,
            'motor' => (int) $data_motor,
            'camera_detail' => $camera_detail
        ];

        return $data;
        //return $camera_detail;
    }

    public function get_speed($id)
    {
        $speed = Speed::where('camera_id', $id)->whereDate('created_at', Carbon::today())->first();

        $data = [
            'speed' => $speed ? $speed['speed'] : 0,
            'camera_id' => $speed ? $speed['camera_id'] : 0,
            'created_at' => $speed ? date_format($speed['created_at'], "Y/m/d H:i:s") : 0,
            'updated_at' => $speed ? date_format($speed['updated_at'], "Y/m/d H:i:s") : 0
        ];

        return $data;
    }

    public function connect_notif()
    {
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

    public function release_notif($id)
    {
        $notif = Anomali::where('id', $id)->update(array('notif' => '1'));
        return $notif;
    }

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

    public function insert_speed($camera_id, $speed, $vehicle)
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

    // INSERT ANOMALI START /////////////////////////////////////////////////////////////

    public function insert_anomali(Request $request)
    {

        $anomali = new Anomali();
        $anomali->camera_id = $request->camera_id;
        $anomali->anomali = $request->anomali;
        $anomali->image = $request->image;
        $anomali->video = $request->video;
        $anomali->lpr = $request->lpr;
        $anomali->user_id = $request->user_id;
        $anomali->lpr_image = $request->lpr_image;
        $insert_anomali = $anomali->save();

        if ($insert_anomali) {
            $this->insert_anomali_rekap($request->camera_id, $request->user_id, $request->anomali);
        }
    }

    public function insert_anomali_rekap($camera_id, $user_id, $anomali_type)
    {

        $now = Carbon::now();
        $now_zero = date('Y-m-d H') . ':00:00';
        $diff = $now->diffInHours(Carbon::parse($now_zero));
        $anomali_rekap = collect([]);

        $anomali_rekap = AnomaliRekap::where('camera_id', $camera_id)
            ->where('anomali_type', $anomali_type)
            ->where('created_at', $now_zero)->first();

        //return $now;

        if ($anomali_rekap && $diff == 0) {
            #add return $count_rekap;
            $inc = DB::table('anomali_rekap')->where('id', $anomali_rekap['id'])->increment('total');
            return $inc;
            //return "belum";
        } else {
            $anomali = new AnomaliRekap();
            $anomali->total = 1;
            $anomali->camera_id = $camera_id;
            $anomali->user_id = $user_id;
            $anomali->anomali_type = $anomali_type;
            $anomali->created_at = $now_zero;
            $anomali->save();

            return "created";
        }
    }

    // INSERT ANOMALI END ############################################################


    // INSERT COUNTING START /////////////////////////////////////////////////////////////

    public function insert_countrecord(Request $request)
    {
        $count_record = new CountRecord();
        $count_record->vehicle = $request->vehicle;
        $count_record->dimensi = $request->dimensi;
        $count_record->camera_id = $request->camera_id;
        $insert_count_record = $count_record->save();

        if ($insert_count_record) {
            $this->insert_counting_rekap($request->camera_id, $request->vehicle);
        }
    }

    public function insert_counting_rekap($camera_id, $vehicle)
    {

        $now = Carbon::now();
        $now_zero = date('Y-m-d H') . ':00:00';
        $diff = $now->diffInHours(Carbon::parse($now_zero));
        $count_rekap = collect([]);

        //return $now_zero." dif ".$diff;

        $count_rekap = CountingRekap::where('camera_id', $camera_id)
            ->where('vehicle', $vehicle)
            ->where('created_at', $now_zero)->first();

        //return $now_zero."-".$diff;
        //return $count_rekap;

        if ($count_rekap && $diff == 0) {

            $inc = DB::table('counting_rekap')->where('id', $count_rekap['id'])->increment('total');
            return "TAMBAH";
        } else {
            $counting = new CountingRekap();
            $counting->total = 1;
            $counting->camera_id = $camera_id;
            $counting->vehicle = $vehicle;
            $counting->created_at = $now_zero;
            $counting->save();
            return "BUAT";
        }
    }

    // INSERT COUNTING END ############################################################

    // INSERT SPEED START /////////////////////////////////////////////////////////////

    public function insert_speedrecord(Request $request)
    {
        if ($request->speed_record != 0) {
            $speed_record = new SpeedRecord();
            $speed_record->vehicle = $request->vehicle;
            $speed_record->speed_record = $request->speed_record;
            $speed_record->camera_id = $request->camera_id;
            $insert = $speed_record->save();

            if ($insert) {
                //return "no";
                $this->insert_speed_rekap($request->camera_id, $request->speed_record, $request->vehicle);
            }
        }
    }

    public function insert_speed_rekap($camera_id, $speed, $vehicle)
    {
        //return "yeah";
        $now = Carbon::now();
        $now_zero = date('Y-m-d H') . ':00:00';
        $diff = $now->diffInHours(Carbon::parse($now_zero));
        $speed_rekap = collect([]);

        $speed_rekap = Speed::where('camera_id', $camera_id)
            ->where('vehicle', $vehicle)
            ->where('created_at', $now_zero)->first();

        //return $speed_rekap;

        if ($speed_rekap && $diff == 0) {
            #add return $count_rekap;
            //$inc = DB::table('speed')->where('id', $speed_rekap['id'])->increment('speed');

            $avg_speed = ($speed_rekap['speed'] + $speed) / 2;

            $speed_avg = Speed::find($speed_rekap['id']);
            $speed_avg->speed = $avg_speed;
            $speed_avg->save();

            return "Masuk bu" . $speed_rekap['speed'] . "+" . $speed . ":" . $avg_speed;
            //return $avg_speed;
        } else {
            $speed_insert = new Speed();
            $speed_insert->camera_id = $camera_id;
            $speed_insert->speed = $speed;
            $speed_insert->vehicle = $vehicle;
            $speed_insert->created_at = $now_zero;
            $speed_insert->save();
            return "created";
        }
    }

    // INSERT SPEED END ############################################################
}

<?php

namespace App\Http\Controllers;
use App\User;
use App\Camera;
use App\CountingRekap;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class KorlantasController extends Controller
{
    //

    public function index()
    {
        #$cameras = Camera::where('user_id', Auth::user()->id)->get();

        $operators = User::where('type', 'operator')->withCount('punyaKamera')->get();
        return view('page.korlantas.page_index', compact('operators'))
        ->with('page', 'Dashboard');
    }

    public function view_volume_kendaraan($id){

        $cameras = Camera::where('user_id', $id)->get();

        $camera = Camera::find($id);

        //return $camera;

        return view('page.korlantas.page_index', compact('camera', 'cameras'))
        ->with('page', 'Keterangan');
    }

    public function view_volume_kendaraan_id($id){
        //$operator = User::where('camera_id', $id)->first();
        //$camera = Camera::find($id)->get();
        // return $id;
        // return $camera;

        $cameras = Camera::where('user_id', $id)->get();
        $operator = User::find($id);
        $random_camera = Camera::orderByRaw("RAND()")->first();
        $data_camera = CountingRekap::orderBy('created_at', 'dsc')->get();

        return view('page.korlantas.page_view_volume_kendaraan', compact('cameras', 'operator', 'random_camera', 'data_camera'))
        ->with('page', 'Keterangan');
    }

    public function view_volume_kendaraan_cam($id_user, $id_camera)
    {
        $cameras = Camera::where('user_id', $id_user)->get();
        $operator = User::find($id_user);
        $selected_camera = Camera::find($id_camera);
        $data_camera = CountingRekap::orderBy('created_at', 'dsc')->get();

        //return $camera;
        return view('page.korlantas.page_view_volume_kendaraan_cam', compact('cameras', 'operator', 'selected_camera', 'data_camera'))
        ->with('page', 'Keterangan');
    }

    public function index_view_volume($id){
        $cameras = Camera::where('user_id', $id)->get();
        $operator = User::find($id);
        $random_camera = Camera::orderByRaw("RAND()")->first();
        $data_camera = CountingRekap::orderBy('created_at', 'dsc')->get();

        return view('page.korlantas.page_index_view_volume', compact('cameras', 'operator', 'random_camera', 'data_camera'))
        ->with('page', 'Keterangan');
    }
}

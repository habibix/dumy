<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use App\Counting;
use App\Camera;
use App\User;
use App\Logs;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\CountingRekap;
use App\License;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function test()
    {
        return view('test');
    }

    public function index()
    {
        if (Auth::user()->type == 'admin') {
            $this->log_userLogin(Auth::user()->id);
            return redirect()->route('admin');
        } elseif (Auth::user()->type == 'super_admin') {
            $this->log_userLogin(Auth::user()->id);
            return redirect()->route('super_admin');
        } elseif (Auth::user()->type == 'operator') {
            $this->log_userLogin(Auth::user()->id);
            return redirect()->route('operator');
        } elseif (Auth::user()->type == 'korlantas') {
            $this->log_userLogin(Auth::user()->id);
            return redirect()->route('korlantas');
        } else {
            //
        }

        //echo Auth::user()->type;

        //echo(arg1)
        //return view('home');
    }

    // LOGS
    public function log_userLogin($id)
    {
        $log = new Logs;
        $log->user_id = $id;
        $log->activity = 'User Login';
        $log->save();
    }

    public function log_userLogout($id)
    {
        $log = new Logs;
        $log->user_id = $id;
        $log->activity = 'User Logout';
        $log->save();
    }

    public function log_userCreate($id)
    {
        $log = new Logs;
        $log->user_id = $id;
        $log->activity = 'Create User';
        $log->save();
    }

    public function log_userDelete($id)
    {
        $log = new Logs;
        $log->user_id = $id;
        $log->activity = 'Delete User';
        $log->save();
    }

    public function log_insertLicense($id)
    {
        $log = new Logs;
        $log->user_id = $id;
        $log->activity = 'Insert License';
        $log->save();
    }

    // ADMIN CASE
    public function admin(Request $req)
    {

        $countAll = CountingRekap::all();
        $camera  = Camera::all();

        return view('page.admin.index')
            ->with('user', User::all())
            ->with('camera', $camera)
            ->with('counting', $countAll);
        //return view('page.admin.index')->withMessage("Admin");
    }

    public function addUser(Request $request)
    {
        // CURD USER

        $this->log_userCreate(Auth::user()->id);

        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = User::firstOrCreate([
            'email' => $request->email
        ], [
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'type' => $request->role,
            'image' => $request->file('image')->getClientOriginalName()
        ]);

        $imageName = $request->file('image')->getClientOriginalName();
        request()->image->move(public_path('img'), $imageName);

        return redirect(route('admin'))->with(['success' => 'User: <strong>' . $user->name . '</strong> Ditambahkan']);
    }

    public function deleteUser($id)
    {
        // CURD USER
        $user = User::findOrFail($id);
        $user->delete();
        $this->log_userDelete(Auth::user()->id);
        return redirect(route('admin'))->with(['success' => 'User Dihapus']);
    }

    public function addCamera(Request $request)
    {
        $camera = Camera::all();
        $license = License::first();
        $license = $license['license_camera'];

        //$this->log_userCreate(Auth::user()->id);

        $this->validate($request, [
            'wilayah' => 'required|string|max:100',
            'lokasi' => 'required|string|max:150',
            'ip_camera' => 'required|ip',
            'user_id' => 'required',
            'area_capture' => 'required',
            'area_khusus' =>'required'
        ]);

        if(count($camera) < 20 ){
            $user = Camera::firstOrCreate([
                'ip_camera' => $request->ip_camera
            ], [
                'wilayah' => $request->wilayah,
                'lokasi' => $request->lokasi,
                'user_id' => $request->user_id,
                'area_capture' => $request->area_capture,
                'area_khusus' => $request->area_khusus,
                'event_speed' => $request->event_speed,
                'event_counting' => $request->event_counting,
                'event_crossing' => $request->event_crossing,
                'restriced_area' => $request->restriced_area
            ]);
    
            return redirect(route('camera'))->with(['success' => 'Kamera Ditambahkan']);
        } else{
            return redirect(route('camera'))->with(['err' => 'Jumlah kamera sudah maksimal']);
        }

        
    }

    public function showLogs()
    {
        // CURD USER
        $logs = Logs::all();
        return view('page.admin.logs')
            ->with('logs', $logs);
    }

    public function insert_license_form()
    {
        $license = License::all();
        return view('page.admin.license', compact('license'));
    }

    public function insert_license(Request $request)
    {
        $request->validate([
            'license' => 'required'
        ]);

        $lic = array();

        $input = Input::all();
        $file = File::get($input['license']);
        $license = base64_decode(base64_decode($file));
        $license = explode(" ", $license);

        echo $lic['license_type'] = $license[1];
        echo $lic['license_camera'] = $license[3];

        $license = new License();
        $license->license_type = $lic['license_type'];
        $license->license_camera = $lic['license_camera'];
        $license->save();

        return redirect(route('license'))->with(['success' => 'License Ditambahkan']);

    }

    public function camera(){
        $camera = Camera::all();
        $user = User::where('type', 'operator')->get();
        return view('page.admin.camera', compact('camera', 'user'));
    }

    // SUPERADMIN CASE
    public function super_admin(Request $req)
    {
        return view('page.superadmin.index')->withMessage("Super Admin");
    }

    // OPERATOR CASE
    public function member(Request $req)
    {
        return view('page.operator.index')->withMessage("Member");
    }
}

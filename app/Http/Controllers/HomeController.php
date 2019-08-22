<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Counting;
use App\User;
use App\Logs;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

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

    public function index()
    {
        if(Auth::user()->type == 'admin'){
            $this->log_userLogin(Auth::user()->id);
            return redirect()->route('admin');

        } elseif(Auth::user()->type == 'super_admin'){
            $this->log_userLogin(Auth::user()->id);
            return redirect()->route('super_admin');

        } elseif(Auth::user()->type == 'operator'){
            $this->log_userLogin(Auth::user()->id);
            return redirect()->route('operator');
            
        } else {
            //
        }

        //echo Auth::user()->type;

        //echo(arg1)
        //return view('home');
    }

    // LOGS
    public function log_userLogin($id){
        $log = new Logs;
        $log->user_id = $id;
        $log->activity = 'User Login';
        $log->save();
    }

    public function log_userLogout($id){
        $log = new Logs;
        $log->user_id = $id;
        $log->activity = 'User Logout';
        $log->save();
    }

    public function log_userCreate($id){
        $log = new Logs;
        $log->user_id = $id;
        $log->activity = 'Create User';
        $log->save();
    }

    public function log_userDelete($id){
        $log = new Logs;
        $log->user_id = $id;
        $log->activity = 'Delete User';
        $log->save();
    }

    public function log_insertLicense($id){
        $log = new Logs;
        $log->user_id = $id;
        $log->activity = 'Insert License';
        $log->save();
    }

    // ADMIN CASE
    public function admin(Request $req){
        $kendaraan = Counting::distinct()->get(['vehicle']);        

        $countMobil = Counting::where('vehicle', '=', 'mobil')->get();
        $countTruk = Counting::where('vehicle', '=', 'truck/bus')->get();
        $countBajai = Counting::where('vehicle', '=', 'bajai')->get();
        $countMotor = Counting::where('vehicle', '=', 'motor')->get();

        //return $countMobil;
        $countAll = Counting::all();
        $countWeek = Counting::where('created_at', '>', Carbon::now()->startOfWeek())
             ->where('created_at', '<', Carbon::now()->endOfWeek())
             ->where('camera', '=', 'camera3.mp4')
             ->get();
        $countWeek2 = Counting::where('created_at', '>', Carbon::now()->startOfWeek())
             ->where('created_at', '<', Carbon::now()->endOfWeek())
             ->where('camera', '=', 'camera1.mp4')
             ->get();
             
        return view('page.admin.index')
            ->with('user', User::all())
            ->with('kendaraan', $kendaraan)
            ->with('countMobil', $countMobil)
            ->with('countTruck', $countTruk)
            ->with('countBajai', $countBajai)
            ->with('countMotor', $countMotor)
            ->with('countWeek', $countWeek)
            ->with('countWeek2', $countWeek2)
            ->with('counting', $countAll);
        //return view('page.admin.index')->withMessage("Admin");
    }

    public function addUser(Request $request){
        // CURD USER

        $this->log_userCreate(Auth::user()->id);

        $this->validate($request, [
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|string'
        ]);

        $user = User::firstOrCreate([
            'email' => $request->email
        ], [
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'type' => $request->role,
        ]);

        return redirect(route('admin'))->with(['success' => 'User: <strong>' . $user->name . '</strong> Ditambahkan']);

    }

    public function deleteUser($id){
        // CURD USER
        $user = User::findOrFail($id);
        $user->delete();
        $this->log_userDelete(Auth::user()->id);
        return redirect(route('admin'))->with(['success' => 'User Dihapus']);
    }

    public function showLogs(){
        // CURD USER
        $logs = Logs::all();
        return view('page.admin.logs')
            ->with('logs', $logs);
    }

    // SUPERADMIN CASE
    public function super_admin(Request $req){
        return view('page.superadmin.index')->withMessage("Super Admin");
    }

    // OPERATOR CASE
    public function member(Request $req){
        return view('page.operator.index')->withMessage("Member");
    }

}

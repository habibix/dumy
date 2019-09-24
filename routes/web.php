<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', 'HomeController@test')->name('test');

Route::get("/new", function(){
	return View::make("page.operator.index");
 });

Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'], function() {
	Route::match(['get', 'post'], '/admin/', 'HomeController@admin')->name('admin');
	Route::match(['get', 'post'], '/admin/adduser/', 'HomeController@addUser')->name('addUser');
	Route::match(['get', 'post'], '/admin/deleteuser/{id}', 'HomeController@deleteUser')->name('deleteUser');
	Route::match(['get', 'post'], '/admin/logs/', 'HomeController@showLogs')->name('showLogs');
	Route::match(['get', 'post'], '/admin/addcamera/', 'HomeController@addCamera')->name('addCamera');
	//Route::match(['get', 'post'], '/admin/deleteuser/{id}', 'HomeController@deleteUser')->name('deleteUser');
});

Route::group(['middleware' => 'App\Http\Middleware\MemberMiddleware'], function() {
	Route::match(['get', 'post'], '/operator/', 'OperatorController@index')->name('operator');
	Route::match(['get', 'post'], '/operator/counting/', 'OperatorController@counting_page')->name('operator_counting');
	Route::match(['get', 'post'], '/operator/counting/{id}', 'OperatorController@counting_page_id')->name('operator_counting_id');
	Route::match(['get', 'post'], '/operator/speed/', 'OperatorController@speed_page')->name('operator_speed');
	Route::match(['get', 'post'], '/operator/speed/{id}', 'OperatorController@speed_page_id')->name('operator_speed_id');
	Route::match(['get', 'post'], '/operator/gis/', 'OperatorController@gis_page')->name('operator_gis');
	Route::match(['get', 'post'], '/operator/gis2/', 'OperatorController@gis_page_2')->name('gis2');
	Route::match(['get', 'post'], '/operator/anomali/', 'OperatorController@anomali')->name('anomali');
	Route::match(['get', 'post'], '/operator/anomali/{id}', 'OperatorController@anomali_id')->name('anomali_id');
	Route::match(['get', 'post'], '/operator/macet/', 'OperatorController@macet')->name('macet');
	Route::match(['get', 'post'], '/operator/macet/{id}', 'OperatorController@macet_id')->name('macet_id');
	Route::match(['get', 'post'], '/operator/view/', 'OperatorController@view_user')->name('view_user');
});

Route::group(['middleware' => 'App\Http\Middleware\SuperAdminMiddleware'], function() {
	Route::match(['get', 'post'], '/superadmin/', 'HomeController@super_admin')->name('super_admin');	
});

Route::group(['middleware' => 'App\Http\Middleware\KorlantasMiddleware'], function() {
	Route::match(['get', 'post'], '/korlantas/', 'KorlantasController@index')->name('korlantas');	
	Route::match(['get', 'post'], '/korlantas/volume/', 'KorlantasController@view_volume_kendaraan')->name('korlantas_view_volume');
	Route::match(['get', 'post'], '/korlantas/volume/{id}', 'KorlantasController@index_view_volume')->name('index_view_volume');
	Route::match(['get', 'post'], '/korlantas/volume/{id_user}/camera/{id_camera}', 'KorlantasController@view_volume_kendaraan_cam')->name('view_volume_kendaraan_cam');
});

Route::get('/insert_counting/{camera_id}/{vehicle}', 'VcaController@insert_counting');
Route::get('/insert_speed', 'VcaController@insert_speed');
Route::post('/insert_anomali', 'VcaController@insert_anomali');

Route::get('/get_value_cam/{id}', 'VcaController@get_value_cam');
Route::get('/get_speed/{id}', 'VcaController@get_speed');

/*
Route::post('/insert_speed', [
	'uses' => 'VcaController@insert_speed',
	'nocsrf' => true,
 ]);
*/
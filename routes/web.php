<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SignupController;
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



Route::get('/',[SignupController::class,'index']);
Route::get('admin',[SignupController::class,'index']);
Route::get('admin/signup',[SignupController::class,'signup']);
Route::post('admin/authsign',[SignupController::class,'authsign']);
Route::post('admin/auth',[SignupController::class,'auth'])->name('admin.auth');
Route::get('admin/forgetpassword',[SignupController::class,'forgetpassword']);
Route::post('admin/forgetpassword_submit',[SignupController::class,'forgetpassword_submit']);

Route::group(['middleware'=>'admin_auth'], function()
{

Route::get('booking',[BookingController::class,'index']);
Route::get('bookinglist',[BookingController::class,'bookinglist']);
Route::get('admin/dashboard',[SignupController::class,'dashboard']);
Route::get('confirmSelection',[BookingController::class,'confirmSelection']);
Route::post('admin/updatepassword',[SignupController::class,'updatepassword']);
Route::get('admin/logout', function () {
    session()->forget('ADMIN_LOGIN');
    session()->forget('ADMIN_ID');
    session()->flash('error','Logout Sucessfully');
    return redirect('admin');
   
});
Route::get('admin/changepassword',[SignupController::class,'changepassword']);
Route::get('admin/logout', function () {
    session()->forget('ADMIN_LOGIN');
    session()->forget('ADMIN_ID');
    session()->flash('error','Logout sucessfully');
    return redirect('admin');
});

});
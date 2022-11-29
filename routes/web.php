<?php

use App\Models\Earth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

// Route::get('/test', function () {
//     $earth = Earth::find(1);
//     return view('test', compact('earth'));
// });

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


//Admin

Route::group(['prefix' => 'admin','middleware' => 'auth'], function(){
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'admin'])->name('admin');

//Customer Profile 
    Route::resource('customer', \App\Http\Controllers\CustomerProfile::class);

//Earth Cotation 
    Route::resource('earth', \App\Http\Controllers\EarthController::class);
    Route::post('earth_status', [\App\Http\Controllers\EarthController::class,'earthStatus'])->name('earth.status');

    //PDF Download
    Route::get('earth/downloadPDF/{id}', [\App\Http\Controllers\EarthController::class,'downloadPDF'])->name('earth.pdf');

//Users 
    Route::resource('user', \App\Http\Controllers\UserController::class);
    Route::post('user_status', [\App\Http\Controllers\UserController::class,'userStatus'])->name('user.status');

});

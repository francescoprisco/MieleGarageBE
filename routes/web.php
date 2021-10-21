<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EBikeController;
use App\Http\Controllers\EBikeConnectorController;
use App\Http\Controllers\SparePartController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TutorialNewsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingController;

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
Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/payment/initiate/{code}/{payment_option_id}/{data}', [PaymentController::class,'initiate'])->name('payment.initiate');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('ebikes', EBikeController::class);
    Route::resource('tutorialnews', TutorialNewsController::class);
    Route::resource('spareparts', SparePartController::class);
    Route::resource('profiles', ProfileController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('ebikesconnector', EBikeConnectorController::class)->except(['show','edit']);
    Route::get('settings/deliveryfees', [SettingController::class,'indexDeliveryFees'])->name('deliveryfees.index');
    Route::get('settings/adddeliveryfees', [SettingController::class,'createDeliveryFees'])->name('deliveryfees.create');
    Route::post('settings/storedeliveryfees', [SettingController::class,'storeDeliveryFees'])->name('deliveryfees.store');
    Route::delete('settings/deletedeliveryfees/{id}', [SettingController::class,'deleteDeliveryFees'])->name('deliveryfees.destroy');

});


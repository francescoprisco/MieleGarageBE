<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EBikeController;
use App\Http\Controllers\API\PCController;
use App\Http\Controllers\API\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//register new user
Route::post('/create-account', [AuthController::class, 'createAccount']);
Route::post('/create-account-fromwp', [AuthController::class, 'createAccountFromWP']);
Route::post('/update-password-fromwp', [AuthController::class, 'updatePasswordFromWP']);

Route::post('/connect/addebike-touser-fromwp', [EBikeController::class, 'connectEBikeToUserFromWP']);

Route::post('/signin', [AuthController::class, 'signin']);
Route::post('/password-recovery', [AuthController::class, 'sendPasswordResetLinkEmail']);
Route::post('/password-reset', [AuthController::class, 'resetPassword'])->name('pwd.reset');

Route::post('/get_cities', [PCController::class, 'getCities'])->name('profiles.getcities');
Route::get('/get_json', [PCController::class, 'getjson']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resource('profiles', ProfileController::class);

    Route::resource('ebikes', EBikeController::class)->only([
        'index', 'show'
    ]);
    Route::post('/sign-out', [AuthController::class, 'signout']);
});


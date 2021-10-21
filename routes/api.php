<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EBikeController;
use App\Http\Controllers\API\PCController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\SparePartController;
use App\Http\Controllers\API\TutorialNewsController;
use App\Http\Controllers\API\DeliveryAddressController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\PaymentOptionController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\DeliveryFeeController;
use App\Http\Controllers\API\EBikeConnectorController;

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
Route::get('/order/payment/update',  [PaymentController::class,'update'])->name('payment.update');
Route::post('/order/payment/update/stripe',  [PaymentController::class,'stripeUpdate']);

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

    Route::resource('ebikes', EBikeController::class)->only(['index', 'show']);

    Route::resource('categories', CategoryController::class)->only(['show']);
    Route::resource('spareparts', SparePartController::class)->only(['show']);

    Route::get('tutorials', [TutorialNewsController::class,'tutorials']);
    Route::get('news', [TutorialNewsController::class,'news']);
    Route::get('tutorialnews/{id}', [TutorialNewsController::class,'showTutorialsNews']);

    Route::apiResource('delivery/addresses', DeliveryAddressController::class);
    Route::get('default/delivery/address', [DeliveryAddressController::class,'default']);
    Route::post('/checkout/initiate', [CheckoutController::class,'initiate']);

    Route::apiResource('/payment/options', PaymentOptionController::class)->only('index');


    Route::apiResource('orders', OrderController::class);
    Route::get('/deliveryfees', [DeliveryFeeController::class,'index']);

    Route::post('/changebikename', [EBikeConnectorController::class, 'changeName']);

    Route::post('/sign-out', [AuthController::class, 'signout']);
});


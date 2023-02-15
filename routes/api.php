<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\PaymentStatusUpdateController;
use App\Http\Controllers\PricesController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/user/register',[UserAuthController::class,'register']);
Route::post('/user/login',[UserAuthController::class,'login']);
Route::post('/payment/{payment:token}',[PaymentStatusUpdateController::class,'updateStatus'])->name('paymentStatus.update');

Route::middleware(['auth:sanctum','UserResourceOwnership'])->group(function(){
    Route::post('/user/logout',[UserAuthController::class,'logout']);
    Route::post('/user/delete',[UserAuthController::class,'delete']);
    Route::apiResource('car', CarController::class);
    Route::apiResource('parking', ParkingController::class);
    Route::apiResource('price', PricesController::class)->except(['index']);
    Route::apiResource('reservation', ReservationController::class)->except(['update']);
});

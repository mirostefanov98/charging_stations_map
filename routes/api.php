<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChargingStationController;
use App\Http\Controllers\Api\UserController;
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

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/info', [UserController::class, 'userInfo']);
    Route::post('/change-password', [UserController::class, 'changePassword']);
    Route::get('/stations', [UserController::class, 'stations']);
});

Route::prefix('station')->group(function () {
    Route::get('/filters', [ChargingStationController::class, 'filters']);
    Route::get('/get', [ChargingStationController::class, 'getStations']);
    Route::get('/{id}', [ChargingStationController::class, 'getStation']);
    Route::post('/create', [ChargingStationController::class, 'create'])->middleware('auth:sanctum');
    Route::post('/like', [ChargingStationController::class, 'likeStation'])->middleware('auth:sanctum');
    Route::post('/dislike', [ChargingStationController::class, 'dislikeStation'])->middleware('auth:sanctum');
});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ParkingController;



Route::middleware(['auth:sanctum' , IsAdmin::class])->group(function(){

});

Route::apiResource('parkings',ParkingController::class);
Route::apiResource('places' , PlaceController::class);

Route::get('/test', function () {
    return response()->json(['message' => 'Test route is working']);
});

Route::post('/register' , [AuthController::class , 'register']);
Route::post('/login' , [AuthController::class , 'login']);
Route::post('/logout' , [AuthController::class , 'logout'])->middleware('auth:sanctum');

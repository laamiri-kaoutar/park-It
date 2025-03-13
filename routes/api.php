<?php

use Illuminate\Http\Request;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\ReservationController;



Route::middleware(['auth:sanctum' , IsAdmin::class])->group(function(){

});

Route::apiResource('parkings',ParkingController::class);
Route::apiResource('places' , PlaceController::class);

Route::get('/test', function () {
    return response()->json(['message' => 'Test route is working']);
});


Route::get('/reservations', [ReservationController::class, 'index']); 
Route::get('/places/{place}/reservations', [ReservationController::class, 'index']); 
Route::get('/Dashboard/statistics', [StatisticsController::class, 'index'])->middleware(['auth:sanctum', IsAdmin::class]);
Route::get('/places/search/{searchkey}', [PlaceController::class, 'search']);



Route::post('/places/{place}/reservations', [ReservationController::class, 'store'])->middleware('auth:sanctum'); 
Route::put('/reservations/{reservation}', [ReservationController::class, 'update']); 
Route::put('/places/{place}/reservations/{reservation}', [ReservationController::class, 'update']); 
Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy']); 



Route::post('/register' , [AuthController::class , 'register']);
Route::post('/login' , [AuthController::class , 'login']);
Route::post('/logout' , [AuthController::class , 'logout'])->middleware('auth:sanctum');

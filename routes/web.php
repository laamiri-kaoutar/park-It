<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    dd(['message' => 'Test route is working']);

    return view('welcome');
});

Route::get('/test', function () {
    dd(['message' => 'Test route is working']);
    return response()->json(['message' => 'Test route is working']);
});
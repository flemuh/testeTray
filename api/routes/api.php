<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn () => response()->json([
    'message' => 'API funcionando',
]));

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

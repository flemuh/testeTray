<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn () => response()->json(['message' => 'API funcionando']));
Route::get('/auth/google/url', [GoogleAuthController::class, 'getLoginUrl']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

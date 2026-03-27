<?php

use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/ping', fn () => response()->json(['message' => 'API funcionando']));
Route::get('/auth/google/url', [GoogleAuthController::class, 'getLoginUrl']);
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback']);

Route::put('/users/{id}/complete-registration', [UserController::class, 'completeRegistration']);
Route::get('/users', [UserController::class, 'index']);

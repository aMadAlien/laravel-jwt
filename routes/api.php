<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')
    ->middleware('api')
    ->controller(AuthController::class)
    ->group(function() {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('register', [AuthController::class, 'register']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);


        Route::get('user', [AuthController::class, 'user']);
});

Route::post('forgot-password', [PasswordController::class, 'forgot']);
Route::post('reset-password', [PasswordController::class, 'reset']);

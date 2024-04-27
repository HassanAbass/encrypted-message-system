<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;

Route::prefix('users')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::prefix('messages')->group(function () {
    Route::post('', [MessageController::class, 'store']);
    Route::post('decrypted', [MessageController::class, 'getMessage']);
})->middleware('auth:api');

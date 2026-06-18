<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route yang bisa diakses tanpa login
Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

// Route yang wajib login (Harus membawa Token JWT)
Route::group(['prefix' => 'auth', 'middleware' => 'auth:api'], function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\BookingController;

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
// 3. Route CRUD Hotel (Menggunakan Resource Route)
Route::apiResource('hotels', HotelController::class);
// Route CRUD Kamar
Route::apiResource('rooms', RoomController::class);
// Route yang wajib login (Harus membawa Token JWT)

Route::prefix('auth')->middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
    
    // Tambahkan dua rute transaksi booking ini di dalam grup auth
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/my-bookings', [BookingController::class, 'myBookings']);
});
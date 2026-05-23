<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\Api\PelangganAuthController;

// Public routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('services', [LaundryController::class, 'getServices']);

// Mobile Auth routes (Menggunakan PelangganAuthController Anda)
Route::post('login-mobile', [PelangganAuthController::class, 'loginMobile']);
Route::post('complete-profile', [PelangganAuthController::class, 'completeProfile']);

// Protected routes (Menggunakan Sanctum yang aman)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('orders', [LaundryController::class, 'getOrders']);
    Route::post('orders', [LaundryController::class, 'createOrder']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});

// Test route
Route::get('test', fn() => response()->json([
    'message' => 'API LaundryMu OK!'
]));
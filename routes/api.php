<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\Api\PelangganAuthController;

// Public routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('services', [LaundryController::class, 'getServices']);

<<<<<<< HEAD
// Mobile Auth routes
Route::post('login-mobile', [PelangganAuthController::class, 'loginMobile']);
Route::post('complete-profile', [PelangganAuthController::class, 'completeProfile']);

// Protected routes (butuh token)
Route::middleware('auth:sanctum')->group(function () {
=======
// LOGIN MOBILE FLUTTER
Route::post('login-mobile', [AuthController::class, 'loginMobile']);
Route::post('complete-profile', [AuthController::class, 'completeProfile']);

// Protected routes
Route::middleware([])->group(function () {

>>>>>>> 584ea24f99ca75bbf9d2a854d25f910dd4583c5c
    Route::get('orders', [LaundryController::class, 'getOrders']);
    Route::post('orders', [LaundryController::class, 'createOrder']);
    Route::post('logout', [AuthController::class, 'logout']);

});

// Test route
Route::get('test', fn() => response()->json([
    'message' => 'API LaundryMu OK!'
]));
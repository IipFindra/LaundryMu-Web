<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaundryController;

// Public routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('services', [LaundryController::class, 'getServices']);

// LOGIN MOBILE FLUTTER
Route::post('login-mobile', [AuthController::class, 'loginMobile']);
Route::post('complete-profile', [AuthController::class, 'completeProfile']);

// Protected routes
Route::middleware([])->group(function () {

    Route::get('orders', [LaundryController::class, 'getOrders']);
    Route::post('orders', [LaundryController::class, 'createOrder']);
    Route::post('logout', [AuthController::class, 'logout']);

});

// Test route
Route::get('test', fn() => response()->json([
    'message' => 'API LaundryMu OK!'
]));
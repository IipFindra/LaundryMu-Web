<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaundryController;

// ─── Public routes ───
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('services', [LaundryController::class, 'getServices']);

// ─── LOGIN MOBILE FLUTTER ───
Route::post('login-mobile', [AuthController::class, 'loginMobile']);
Route::post('complete-profile', [AuthController::class, 'completeProfile']);

// ─── MOBILE API ROUTES (stateless, no auth middleware) ───
Route::post('orders', [LaundryController::class, 'createOrder']);
Route::get('orders/pelanggan', [LaundryController::class, 'getOrdersByPelanggan']);
Route::get('tracking/{id}', [LaundryController::class, 'getTracking']);

// ─── Protected routes ───
Route::middleware([])->group(function () {
    Route::get('orders', [LaundryController::class, 'getOrders']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
});

// ─── Test route ───
Route::get('test', fn() => response()->json([
    'message' => 'API LaundryMu OK!'
]));
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\Api\LayananApiController;

// ─── Public routes ───
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('services', [LaundryController::class, 'getServices']);

// ─── LOGIN MOBILE FLUTTER ───
Route::post('login-mobile', [AuthController::class, 'loginMobile']);
Route::post('complete-profile', [AuthController::class, 'completeProfile']);

// ─── MOBILE API ROUTES (stateless, no auth middleware) ───
Route::get('layanans', [LayananApiController::class, 'index']);
Route::post('orders', [LaundryController::class, 'createOrder']);
Route::get('orders/pelanggan', [LaundryController::class, 'getOrdersByPelanggan']);
Route::get('tracking/{id}', [LaundryController::class, 'getTracking']);
Route::post('chat/receive', [\App\Http\Controllers\DashboardController::class, 'receiveCustomerMessage']);

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
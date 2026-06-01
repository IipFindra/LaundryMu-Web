<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaundryController;
use App\Http\Controllers\Api\LayananApiController;
use App\Http\Controllers\Api\PelangganAuthController;
use App\Http\Controllers\Api\ChatController; // <-- TAMBAHKAN INI UNTUK CHAT

// ─── Public routes ───
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::get('services', [LaundryController::class, 'getServices']);

// ─── LOGIN MOBILE FLUTTER ───
Route::post('login-mobile', [PelangganAuthController::class, 'loginMobile']);
Route::post('complete-profile', [PelangganAuthController::class, 'completeProfile']);

// ─── EDIT PROFILE MOBILE FLUTTER ───
Route::post('update-nama', [PelangganAuthController::class, 'updateNama']);

// ─── MOBILE API ROUTES (stateless, no auth middleware) ───
Route::get('layanans', [LayananApiController::class, 'index']);
Route::post('orders', [LaundryController::class, 'createOrder']);
Route::get('orders/pelanggan', [LaundryController::class, 'getOrdersByPelanggan']);
Route::get('tracking/{id}', [LaundryController::class, 'getTracking']);

// ─── CHAT MOBILE FLUTTER (TAMBAHKAN INI) ───
Route::get('chat/get', [ChatController::class, 'getMessages']);
Route::post('chat/send', [ChatController::class, 'sendMessage']);
Route::put('chat/update/{id}', [ChatController::class, 'updateMessage']);
Route::delete('chat/delete/{id}', [ChatController::class, 'deleteMessage']);

// ─── ROUTE CHAT UNTUK WEB ADMIN (BIARKAN APA ADANYA) ───
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

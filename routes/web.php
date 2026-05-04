<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

// Halaman awal (Landing Page)
Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Forgot password
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');


/*
|--------------------------------------------------------------------------
| Protected (WAJIB LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Pesanan
    Route::get('/pesanan', [PesananController::class, 'index'])
        ->name('pesanan');

    Route::get('/pesanan/{id}/struk', [PesananController::class, 'generateStruk'])
        ->name('pesanan.struk');

    Route::get('/pesanan/{id}/struk/{format}', [PesananController::class, 'generateStruk'])
        ->name('pesanan.struk.format');

    // Edit Pesanan
    Route::get('/edit-pesanan/{id}', [PesananController::class, 'editPesanan'])
        ->name('edit.pesanan');

    Route::post('/edit-pesanan/{id}', [PesananController::class, 'updatePesanan'])
        ->name('edit.pesanan.update');

});

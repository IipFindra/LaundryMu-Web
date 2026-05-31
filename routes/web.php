<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileAdminController;


/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

// Halaman awal (Landing Page)
Route::get('/', function () {
    $layanans = \App\Models\Layanan::whereIn('status', ['Aktif', 'Segera Hadir'])->get();
    return view('welcome', compact('layanans'));
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

    // Pelanggan
    Route::get('/pelanggan', function () {
        $pelanggans = App\Models\Pelanggan::latest()->get();
        return view('pelanggan', compact('pelanggans'));
    })->name('pelanggan');

    // Layanan
    Route::get('/layanan', [LayananController::class, 'index'])->name('layanan');
    Route::post('/layanan', [LayananController::class, 'store'])->name('layanan.store');
    Route::put('/layanan/{id}', [LayananController::class, 'update'])->name('layanan.update');
    Route::delete('/layanan/{id}', [LayananController::class, 'destroy'])->name('layanan.destroy');

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export.pdf');

    Route::get('/pesanan/{id}/struk', [PesananController::class, 'generateStruk'])
        ->name('pesanan.struk');

    Route::get('/pesanan/{id}/struk/{format}', [PesananController::class, 'generateStruk'])
        ->name('pesanan.struk.format');

    // Edit Pesanan
    Route::get('/edit-pesanan/{id}', [PesananController::class, 'editPesanan'])
        ->name('edit.pesanan');

    Route::post('/edit-pesanan/{id}', [PesananController::class, 'updatePesanan'])
        ->name('edit.pesanan.update');

    // Update Status Tracking (khusus sinkron Flutter)
    Route::post('/pesanan/{id}/update-status', [PesananController::class, 'updateStatus'])
        ->name('pesanan.update.status');

    // Dashboard API Routes (Search, Notifications, Messages)
    Route::get('/api/search', [DashboardController::class, 'search'])->name('api.search');
    Route::post('/api/notifications/read', [DashboardController::class, 'markNotifRead'])->name('api.notif.read');
    Route::post('/api/messages/read', [DashboardController::class, 'markMessageRead'])->name('api.message.read');
    Route::get('/api/notifications', [DashboardController::class, 'getNotifications'])->name('api.notifications');
    Route::get('/api/messages', [DashboardController::class, 'getMessages'])->name('api.messages');
    Route::get('/api/admin/chat/{id_pelanggan}', [DashboardController::class, 'getChatHistory'])->name('api.admin.chat.history');
    Route::post('/api/admin/chat/send', [DashboardController::class, 'sendChatMessage'])->name('api.admin.chat.send');
    Route::put('/api/admin/chat/{id}', [DashboardController::class, 'updateChatMessage'])->name('api.admin.chat.update');
    Route::delete('/api/admin/chat/{id}', [DashboardController::class, 'deleteChatMessage'])->name('api.admin.chat.delete');

    // ─── Profil Admin ─────────────────────────────────────────────────
    Route::get('/profile-admin',               [ProfileAdminController::class, 'index'])         ->name('profile.admin');
    Route::post('/profile-admin/update',       [ProfileAdminController::class, 'update'])        ->name('profile.admin.update');
    Route::post('/profile-admin/update-password', [ProfileAdminController::class, 'updatePassword'])->name('profile.admin.update.password');
    Route::post('/profile-admin/update-photo', [ProfileAdminController::class, 'updatePhoto'])   ->name('profile.admin.update.photo');

});

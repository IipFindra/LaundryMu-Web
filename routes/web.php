<?php

use Illuminate\Support\Facades\Route;

// Halaman Utama (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Halaman Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// ⬇️ TAMBAHKAN DI SINI
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');


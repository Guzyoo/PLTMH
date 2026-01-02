<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\ManageUserController;

// ==========================================
// 1. PUBLIC ROUTES (Bisa diakses Guest/Siapa saja)
// ==========================================

// Halaman Dashboard Utama (Welcome)
Route::get('/', function () {
    return view('welcome');
})->name('dashboard'); // Kasih nama biar gampang dipanggil

// Halaman History
Route::get('/history', function () {
    return view('history');
});

// Login & Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

// ==========================================
// 2. PRIVATE ROUTES (Harus Login Dulu)
// ==========================================

Route::middleware(['auth'])->group(function () {

    // Halaman Manajemen Device (Hanya Admin/User Terdaftar)
    Route::get('/devices', [DeviceController::class, 'index'])->name('devices.index');
    Route::get('/manage', [ManageUserController::class, 'index'])->name('manage.index');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

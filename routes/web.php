<?php

use App\Http\Controllers\DeviceController;
use App\Models\Sensor;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('devices', [DeviceController::class, 'index'])->name('devices.index');

Route::get('/history', function () {
    return view('history'); // Panggil file history.blade.php
});

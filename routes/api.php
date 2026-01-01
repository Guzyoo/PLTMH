<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorController;

Route::post('/devices/{device}/sensors', [SensorController::class, 'store']);

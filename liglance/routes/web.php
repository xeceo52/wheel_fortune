<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WheelController;

Route::get('/', [WheelController::class, 'index']);
Route::post('/spin', [WheelController::class, 'spin']);

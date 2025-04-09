<?php

use App\Http\Controllers\Api\LocationController;
use Illuminate\Support\Facades\Route;

Route::name('auth.')->group(base_path('routes/auth/index.php'));

Route::middleware('auth:sanctum')->apiResource('locations', LocationController::class);

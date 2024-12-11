<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Product\ChangeAvailableProductController;
use App\Http\Controllers\Api\Product\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});

/*
|--------------------------------------------------------------------------
| Sanctum Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    // product
    Route::apiResource('products', ProductController::class);
    Route::put('products/{product}/available', ChangeAvailableProductController::class)
        ->name('products.available');
});

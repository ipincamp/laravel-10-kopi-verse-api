<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Product\ChangeAvailableProductController;
use App\Http\Controllers\Api\Product\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'success' => true,
        'message' => 'Welcome to the API',
        'data' => [],
        'errors' => null,
    ], 200);
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
    Route::get('/me', 'profile')->middleware('auth:sanctum');
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

    // cart
    Route::apiResource('cart', CartController::class)->only(['index', 'store']);
    Route::put('cart', [CartController::class, 'update'])->name('cart.update');

    // order
    Route::apiResource('orders', OrderController::class)->only(['index', 'store']);
    Route::put('orders/{order:barcode}/status', [OrderController::class, 'update'])
        ->name('orders.status');
    Route::get('orders/{order:barcode}', [OrderController::class, 'show'])
        ->name('orders.show');
});

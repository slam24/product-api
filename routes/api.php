<?php
use App\Infrastructure\Http\Controllers\AuthController;
use App\Infrastructure\Http\Controllers\ProductController;
use App\Infrastructure\Http\Controllers\CurrencyController;
use App\Infrastructure\Http\Controllers\ProductPriceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::get('/health', function () {
        return response()->json(['status' => 'ok']);
    });

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('products', ProductController::class);
        Route::apiResource('currencies', CurrencyController::class);
        Route::get('products/{id}/prices', [ProductPriceController::class, 'index']);
        Route::post('products/{id}/prices', [ProductPriceController::class, 'store']);
        Route::delete('products/{id}/prices/{price}', [ProductPriceController::class, 'destroy']);
    });
});
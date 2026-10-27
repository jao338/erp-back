<?php

use ERP\Auth\AuthController;
use ERP\Models\Product\ProductController;
use ERP\Models\Sale\SaleController;
use ERP\Models\Shopping\ShoppingController;
use ERP\Models\Supplier\SupplierController;
use ERP\Models\Client\ClientController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'api',
], function (): void {

    Route::group([
        'namespace' => 'Auth',
    ], function (): void {
        Route::post('login', [AuthController::class, 'login'])
            ->name('login')
            ->middleware(['throttle:attemps-auth', 'guest']);

        Route::post('register', [AuthController::class, 'register'])
            ->name('register')
            ->middleware(['throttle:attemps-auth', 'guest']);

        Route::post('first-access', [AuthController::class, 'firstAccess'])
            ->name('first.access')
            ->middleware(['throttle:attemps-auth', 'guest']);

        Route::post('verify-code-access', [AuthController::class, 'verifyCodeAccess'])
            ->name('verify.first.access')
            ->middleware(['throttle:attemps-auth', 'guest']);
    });

    Route::group([
        'middleware' => ['auth:sanctum'],
    ], function (): void {
        Route::get('me', [AuthController::class, 'me'])->name('me');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::apiResource('products', ProductController::class)->names('products');

        Route::apiResource('suppliers', SupplierController::class)
            ->only(['index', 'show'])
            ->names('suppliers');

        Route::apiResource('clients', ClientController::class)
            ->only(['index', 'show'])
            ->names('clients');

        Route::apiResource('shopping', ShoppingController::class)
            ->only(['index', 'show', 'store', 'destroy'])
            ->names('shopping');

        Route::apiResource('sale', SaleController::class)
            ->only(['index', 'show', 'store', 'destroy'])
            ->names('sale');
    });
});

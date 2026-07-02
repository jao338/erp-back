<?php

use Base\Models\Auth\AuthController;
use Base\Models\Product\ProductController;
use Base\Models\Supplier\SupplierController;
use Base\Models\Shopping\ShoppingController;
use Base\Models\Client\ClientController;
use Base\Models\Sale\SaleController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'api',
], function (): void {

    Route::group([
        'namespace' => 'Auth'
    ], function (): void {
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::post('register', [AuthController::class, 'register'])->name('register');
    });

    Route::group([
        'middleware' => ['auth:sanctum'],
    ], function (): void {

         Route::group([
            'prefix' => 'lookups'
        ], function (): void {
            Route::get('suppliers', [SupplierController::class, 'lookup'])->name('lookups.suppliers');
            Route::get('clients', [ClientController::class, 'lookup'])->name('lookups.clients');
        });

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

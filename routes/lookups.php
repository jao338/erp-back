<?php

use Base\Models\Client\ClientController;
use Base\Models\Supplier\SupplierController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'api',
    'middleware' => ['auth:sanctum'],
], function (): void {
    Route::group([
        'prefix' => 'lookups',
    ], function (): void {
        Route::get('suppliers', [SupplierController::class, 'lookup'])->name('lookups.suppliers');
        Route::get('clients', [ClientController::class, 'lookup'])->name('lookups.clients');
    });
});

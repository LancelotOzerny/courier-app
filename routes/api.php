<?php

use App\Http\Controllers\Api\OrderImportController;
use Illuminate\Support\Facades\Route;

Route::middleware('courier.api')->post('/orders', [OrderImportController::class, 'store'])
    ->name('api.orders.store');

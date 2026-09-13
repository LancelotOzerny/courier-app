<?php

use App\Http\Controllers\Api\OrderImportController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('courier.api')->group(function (): void {
    Route::post('/orders', [OrderImportController::class, 'store'])->name('api.orders.store');
    Route::get('/users', [UserController::class, 'index'])->name('api.users.index');
    Route::post('/users', [UserController::class, 'store'])->name('api.users.store');
});

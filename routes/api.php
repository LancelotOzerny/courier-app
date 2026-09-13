<?php

use App\Http\Controllers\Api\OrderImportController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('courier.api')->group(function (): void {
    Route::get('/orders', [OrderImportController::class, 'index'])->name('api.orders.index');
    Route::post('/orders', [OrderImportController::class, 'store'])->name('api.orders.store');
    Route::patch('/orders/{orderNumber}/courier', [OrderImportController::class, 'updateCourier'])
        ->whereNumber('orderNumber')
        ->name('api.orders.courier.update');
    Route::patch('/orders/{orderNumber}/parcel-locker', [OrderImportController::class, 'updateParcelLocker'])
        ->whereNumber('orderNumber')
        ->name('api.orders.parcel-locker.update');
    Route::get('/users', [UserController::class, 'index'])->name('api.users.index');
    Route::post('/users', [UserController::class, 'store'])->name('api.users.store');
});

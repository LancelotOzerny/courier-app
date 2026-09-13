<?php

use App\Http\Controllers\CourierPageController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [CourierPageController::class, 'login'])->name('login');
    Route::post('/login', [CourierPageController::class, 'authenticate'])->name('login.attempt');
});

Route::middleware('auth')->group(function (): void {
    Route::get('/', [CourierPageController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders', [CourierPageController::class, 'orders'])->name('orders.index');
    Route::get('/orders/{order}', [CourierPageController::class, 'showOrder'])
        ->whereNumber('order')
        ->name('orders.show');
    Route::get('/notifications', [CourierPageController::class, 'notifications'])->name('notifications.index');
    Route::get('/settings', [CourierPageController::class, 'settings'])->name('settings');
    Route::post('/logout', [CourierPageController::class, 'logout'])->name('logout');
});

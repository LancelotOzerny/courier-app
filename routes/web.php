<?php

use App\Http\Controllers\CourierPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CourierPageController::class, 'dashboard'])->name('dashboard');
Route::get('/login', [CourierPageController::class, 'login'])->name('login');
Route::get('/orders', [CourierPageController::class, 'orders'])->name('orders.index');
Route::get('/orders/{order}', [CourierPageController::class, 'showOrder'])
    ->whereNumber('order')
    ->name('orders.show');
Route::get('/notifications', [CourierPageController::class, 'notifications'])->name('notifications.index');
Route::get('/settings', [CourierPageController::class, 'settings'])->name('settings');

<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class CourierPageController extends Controller
{
    public function dashboard(): View
    {
        return view('courier.dashboard');
    }

    public function login(): View
    {
        return view('courier.login');
    }

    public function orders(): View
    {
        return view('courier.orders');
    }

    public function showOrder(int $order): View
    {
        return view('courier.order', ['orderNumber' => $order]);
    }

    public function notifications(): View
    {
        return view('courier.notifications');
    }

    public function settings(): View
    {
        return view('courier.settings');
    }
}

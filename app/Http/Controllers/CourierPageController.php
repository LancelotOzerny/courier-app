<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourierPageController extends Controller
{
    public function dashboard(): View
    {
        $ordersCount = Order::query()
            ->where('courier_id', auth()->id())
            ->count();

        return view('courier.dashboard', compact('ordersCount'));
    }

    public function login(): View
    {
        return view('courier.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials)) {
            return back()->withErrors(['login' => 'Неверный логин или пароль.'])->onlyInput('login');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function orders(): View
    {
        $orders = Order::query()
            ->with('parcelLocker')
            ->where('courier_id', auth()->id())
            ->orderByDesc('courier_created_at')
            ->get();

        return view('courier.orders', compact('orders'));
    }

    public function showOrder(int $orderNumber): View
    {
        $order = Order::query()
            ->with(['parcelLocker', 'items', 'lockerCells'])
            ->where('number', $orderNumber)
            ->where('courier_id', auth()->id())
            ->firstOrFail();

        return view('courier.order', compact('order'));
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

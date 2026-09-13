<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

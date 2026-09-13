<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

test('guest is redirected to login from protected courier pages', function (string $url) {
    $response = $this->get($url);

    $response->assertRedirect(route('login'));
})->with([
    '/',
    '/orders',
    '/orders/1842',
    '/notifications',
    '/settings',
]);

test('login page is available to a guest', function () {
    $this->get(route('login'))->assertOk();
});

test('courier can sign in by login and sees own login', function () {
    $user = User::factory()->create([
        'login' => 'courier-test',
        'password_hash' => Hash::make('secret-password'),
    ]);

    $this->post(route('login.attempt'), [
        'login' => 'courier-test',
        'password' => 'secret-password',
    ])->assertRedirect(route('dashboard'));

    $this->assertAuthenticatedAs($user);
    $this->get(route('dashboard'))->assertOk()->assertSee('courier-test');
});

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
    $this->get(route('dashboard'))
        ->assertOk()
        ->assertSee("[{$user->id}] courier-test")
        ->assertSee('Доступно заказов')
        ->assertSee('0');
    $this->get(route('orders.index'))->assertOk()->assertSee('Вам пока не назначены заказы.');
    $this->get(route('settings'))
        ->assertOk()
        ->assertSee($user->email)
        ->assertSee($user->phone)
        ->assertDontSee('ID пользователя');
});

test('orders API requires an API token', function () {
    $this->postJson(route('api.orders.store'))->assertUnauthorized();
});

test('orders API creates an order for the specified courier', function () {
    config()->set('courier.orders_api_token', 'test-api-token');

    $courier = User::factory()->create(['login' => 'api-courier']);

    $this->postJson(route('api.orders.store'), [
        'number' => 1842,
        'courier_login' => $courier->login,
        'courier_created_at' => '2026-09-13T14:20:00+03:00',
        'parcel_locker' => [
            'number' => 'ПВЗ-07',
            'address' => 'ул. Ленина, 12',
        ],
        'items' => [
            ['name' => 'Вода 5 л', 'quantity' => 2],
            ['name' => 'Хлеб', 'quantity' => 1],
        ],
        'cells' => ['A-12', 'A-13'],
    ], ['X-API-Token' => 'test-api-token'])
        ->assertCreated()
        ->assertJsonPath('data.number', 1842)
        ->assertJsonPath('data.courier_login', 'api-courier')
        ->assertJsonPath('data.parcel_locker.number', 'ПВЗ-07')
        ->assertJsonPath('data.cells.0', 'A-12');

    $this->assertDatabaseHas('orders', [
        'number' => 1842,
        'courier_id' => $courier->id,
    ]);
    $this->assertDatabaseCount('order_items', 2);
    $this->assertDatabaseCount('order_cells', 2);
});

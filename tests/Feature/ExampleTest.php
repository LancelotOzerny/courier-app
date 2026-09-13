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

test('orders API creates an unassigned order and later assigns a courier', function () {
    config()->set('courier.orders_api_token', 'test-api-token');

    $this->postJson(route('api.orders.store'), [
        'number' => 1852,
        'parcel_locker' => [
            'number' => 'ПВЗ-12',
            'address' => 'ул. Победы, 3',
        ],
        'items' => [['name' => 'Чай', 'quantity' => 1]],
        'cells' => ['B-01'],
    ], ['X-API-Token' => 'test-api-token'])
        ->assertCreated()
        ->assertJsonPath('data.courier_login', null)
        ->assertJsonPath('data.courier_created_at', null);

    $this->getJson(route('api.orders.index'), ['X-API-Token' => 'test-api-token'])
        ->assertOk()
        ->assertJsonCount(1, 'data')
        ->assertJsonPath('data.0.number', 1852);

    $courier = User::factory()->create(['login' => 'assigned-courier']);

    $this->patchJson(route('api.orders.courier.update', ['orderNumber' => 1852]), [
        'courier_login' => $courier->login,
    ], ['X-API-Token' => 'test-api-token'])
        ->assertOk()
        ->assertJsonPath('data.courier_login', 'assigned-courier');

    $this->assertDatabaseHas('orders', [
        'number' => 1852,
        'courier_id' => $courier->id,
    ]);
});

test('users API returns a paginated list without password hashes', function () {
    config()->set('courier.orders_api_token', 'test-api-token');

    $users = User::factory()->count(3)->create();

    $this->getJson(route('api.users.index', ['limit' => 2]), ['X-API-Token' => 'test-api-token'])
        ->assertOk()
        ->assertJsonCount(2, 'data')
        ->assertJsonPath('meta.total', 3)
        ->assertJsonPath('meta.limit', 2)
        ->assertJsonPath('meta.current_page', 1)
        ->assertJsonPath('meta.last_page', 2)
        ->assertDontSee($users->first()->password_hash);
});

test('users API creates a user and stores only a password hash', function () {
    config()->set('courier.orders_api_token', 'test-api-token');

    $response = $this->postJson(route('api.users.store'), [
        'login' => 'petr',
        'email' => 'petr@example.test',
        'phone' => '+79990000005',
        'password' => 'Safe-password-2026',
    ], ['X-API-Token' => 'test-api-token']);

    $response
        ->assertCreated()
        ->assertJsonPath('data.login', 'petr')
        ->assertJsonPath('data.email', 'petr@example.test')
        ->assertJsonMissing(['password' => 'Safe-password-2026']);

    $user = User::query()->where('login', 'petr')->firstOrFail();

    expect(Hash::check('Safe-password-2026', $user->password_hash))->toBeTrue();
});

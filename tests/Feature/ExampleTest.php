<?php

test('courier pages return a successful response', function (string $url) {
    $response = $this->get($url);

    $response->assertStatus(200);
})->with([
    '/',
    '/login',
    '/orders',
    '/orders/1842',
    '/notifications',
    '/settings',
]);

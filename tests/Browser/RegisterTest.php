<?php

use function Pest\Laravel\{post, assertAuthenticated};

test('it registers a user', function () {
    $response = post('/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/');
    assertAuthenticated();

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);
});

test('it requires valid email for registration', function () {
    $response = post('/register', [
        'name' => 'John Doe',
        'email' => 'not-an-email',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertSessionHasErrors(['email']);
    $response->assertInvalid(['email']); // ← assertInvalid kullan
});

test('it requires password confirmation', function () {
    $response = post('/register', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password123',
        'password_confirmation' => 'different',
    ]);

    $response->assertSessionHasErrors(['password']);
    $response->assertInvalid(['password']); // ← assertInvalid kullan
});

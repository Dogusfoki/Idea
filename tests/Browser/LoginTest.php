<?php

use App\Models\User;

use function Pest\Laravel\{post, assertAuthenticatedAs, assertGuest};

test('it logs in a user', function () {
    $user = User::factory()->create([
        'password' => bcrypt('password123'),
    ]);

    $response = post('/login', [
        'email' => $user->email,
        'password' => 'password123',
    ]);

    $response->assertRedirect('/');
    assertAuthenticatedAs($user);
});

test('it fails login with invalid credentials', function () {
    $response = post('/login', [
        'email' => 'nonexistent@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertSessionHasErrors(['password']);
    $response->assertInvalid(['password']);
    assertGuest();
});

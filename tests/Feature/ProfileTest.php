<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('it requires authentication', function () {
    $this->get('/profile/edit')->assertRedirect('/login');
});

test('user can view their profile edit page with current values', function () {
    $user = User::factory()->create(['name' => 'Dogus']);

    $this->actingAs($user)
        ->get('/profile/edit')
        ->assertSee('Dogus');
});

test('user can update their name and email', function () {
    $user = User::factory()->create([
        'name' => 'Old Name',
        'email' => 'old@example.com',
    ]);

    $response = $this->actingAs($user)
        ->patch('/profile', [
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

    $response->assertRedirect(route('profile.edit'));

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'New Name',
        'email' => 'new@example.com',
    ]);
});

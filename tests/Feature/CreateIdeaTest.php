<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can create an idea', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post('/ideas', [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'status' => 'pending',
        ]);

    $response->assertRedirect('/ideas');

    $this->assertDatabaseHas('ideas', [
        'title' => 'Test Title',
        'description' => 'Test Description',
        'status' => 'pending',
        'user_id' => $user->id,
    ]);
});

test('guest cannot create an idea', function () {
    $response = $this->post('/ideas', [
        'title' => 'Test Title',
        'description' => 'Test Description',
        'status' => 'pending',
    ]);

    $response->assertRedirect('/login');
});

test('idea requires title and description', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->post('/ideas', [
            'title' => '',
            'description' => '',
            'status' => 'pending',
        ]);

    $response->assertSessionHasErrors(['title', 'description']);
});

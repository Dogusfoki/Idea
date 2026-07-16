<?php

use App\Models\Idea;
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

test('user can update their own idea', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->for($user)->create([
        'title' => 'Old Title',
    ]);

    $response = $this->actingAs($user)
        ->put(route('ideas.update', $idea), [
            'title' => 'Updated Title',
            'description' => 'Updated Description',
            'status' => 'in_progress',
            'links' => ['https://example.com'],
            'steps' => ['Do the thing'],
        ]);

    $response->assertRedirect(route('ideas.show', $idea));

    $this->assertDatabaseHas('ideas', [
        'id' => $idea->id,
        'title' => 'Updated Title',
        'description' => 'Updated Description',
    ]);

    expect($idea->fresh()->steps)->toHaveCount(1);
    expect($idea->fresh()->links)->toContain('https://example.com');
});

test('user cannot update an idea they do not own', function () {
    $owner = User::factory()->create();
    $otherUser = User::factory()->create();
    $idea = Idea::factory()->for($owner)->create();

    $response = $this->actingAs($otherUser)
        ->put(route('ideas.update', $idea), [
            'title' => 'Hacked Title',
            'description' => 'Hacked Description',
            'status' => 'pending',
        ]);

    $response->assertForbidden();

    $this->assertDatabaseHas('ideas', [
        'id' => $idea->id,
        'title' => $idea->title,
    ]);
});

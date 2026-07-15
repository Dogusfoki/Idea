<?php

use App\Models\Idea;
use App\Models\User;

it('requires authentication', function () {
    $idea = Idea::factory()->create();
    $this->get(route('ideas.show', $idea))->assertRedirect(route('login'));
});

it('disallows accessing an idea you did not create', function () {
    $user = User::factory()->create();
    $idea = Idea::factory()->create();

    $this->actingAs($user)
        ->get(route('ideas.show', $idea))
        ->assertForbidden();
});

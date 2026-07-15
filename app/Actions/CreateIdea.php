<?php

namespace App\Actions;

use App\Models\Idea;
use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Support\Facades\DB;

class CreateIdea
{
    public function __construct(
        #[CurrentUser] protected User $user
    ) {
    }

    public function handle(array $attributes): Idea
    {
        return DB::transaction(function () use ($attributes) {
            $data = collect($attributes)->only(['title', 'description', 'status', 'links'])->toArray();
            if ($attributes['image'] ?? false) {
                $data['image_path'] = $attributes['image']->store('ideas', 'public');
            }
            $data['user_id'] = $this->user->id;

            $idea = Idea::create($data);

            $idea->steps()->createMany(
                collect($attributes['steps'] ?? [])->map(fn ($step) => ['description' => $step])
            );
            return $idea;

        });
    }
}

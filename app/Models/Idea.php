<?php

namespace App\Models;

use App\Enums\IdeaStatus;
use App\Models\Step;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    /** @use HasFactory<\Database\Factories\IdeaFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id'
        ];

    protected $casts = [
        'links' => 'array',
        'status' => IdeaStatus::class,
    ];

    protected $attributes = [
        'status' => 'pending',
        'links' => '[]',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public static function statusCounts($user)
    {
        $statuses = IdeaStatus::cases();

        $counts = collect($statuses)->mapWithKeys(function ($status) use ($user) {
            $count = $user->ideas()->where('status', $status->value)->count();
            return [$status->value => $count];
        });

        $counts->put('all', $user->ideas()->count());
        return $counts;
    }
}

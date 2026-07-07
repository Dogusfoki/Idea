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
}

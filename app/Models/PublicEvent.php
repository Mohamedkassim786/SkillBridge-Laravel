<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicEvent extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'title',
        'slug',
        'event_type',
        'instructor_name',
        'instructor_avatar',
        'starts_at',
        'duration_mins',
        'meeting_url',
        'cover_image',
        'description',
        'is_upcoming',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'is_upcoming' => 'boolean',
    ];
}

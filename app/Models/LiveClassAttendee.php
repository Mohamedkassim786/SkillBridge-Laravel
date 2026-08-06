<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveClassAttendee extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'live_class_attendees';

    protected $fillable = [
        'live_class_id',
        'student_id',
        'joined_at',
        'left_at',
        'last_seen_at',
        'duration_minutes',
        'attendance_status',
        'ip_address',
    ];

    protected function casts(): array
    {
        return [
            'joined_at' => 'datetime',
            'left_at' => 'datetime',
            'last_seen_at' => 'datetime',
            'duration_minutes' => 'integer',
        ];
    }

    public function liveClass(): BelongsTo
    {
        return $this->belongsTo(LiveClass::class, 'live_class_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}

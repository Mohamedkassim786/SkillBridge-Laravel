<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LiveClass extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'live_classes';

    protected $fillable = [
        'course_id',
        'batch_id',
        'trainer_id',
        'title',
        'description',
        'room_name',
        'provider',
        'start_at',
        'end_at',
        'duration_minutes',
        'status',
        'attendance_required',
        'recording_enabled',
        'recording_url',
        'recording_status',
        'published_at',
        'cancelled_at',
        'cancellation_reason',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
            'published_at' => 'datetime',
            'cancelled_at' => 'datetime',
            'attendance_required' => 'boolean',
            'recording_enabled' => 'boolean',
            'duration_minutes' => 'integer',
        ];
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attendees(): HasMany
    {
        return $this->hasMany(LiveClassAttendee::class, 'live_class_id');
    }

    public function materials(): HasMany
    {
        return $this->hasMany(LiveClassMaterial::class, 'live_class_id');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(LiveClassFeedback::class, 'live_class_id');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeLive($query)
    {
        return $query->where('status', 'live');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function isPublishedRecording(): bool
    {
        return $this->recording_status === 'published' && ! empty($this->recording_url);
    }
}

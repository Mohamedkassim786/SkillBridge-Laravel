<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MockInterview extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'student_id',
        'job_id',
        'resume_id',
        'interview_type',
        'role',
        'technology',
        'difficulty',
        'interview_state',
        'max_questions',
        'mode',
        'voice',
        'duration',
        'status',
        'overall_score',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'difficulty' => 'integer',
        'max_questions' => 'integer',
        'interview_state' => 'array',
        'duration' => 'integer',
        'overall_score' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(JobPosting::class, 'job_id');
    }

    public function resume(): BelongsTo
    {
        return $this->belongsTo(UserResume::class, 'resume_id');
    }

    public function questions(): HasMany
    {
        return $this->hasMany(InterviewQuestion::class, 'mock_interview_id')->orderBy('sequence');
    }

    public function report(): HasOne
    {
        return $this->hasOne(InterviewReport::class, 'mock_interview_id');
    }
}

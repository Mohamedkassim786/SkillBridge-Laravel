<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InterviewQuestion extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'mock_interview_id',
        'question',
        'question_type',
        'topic',
        'difficulty',
        'sequence',
        'ai_metadata',
        'asked_at',
    ];

    protected $casts = [
        'difficulty' => 'integer',
        'sequence' => 'integer',
        'ai_metadata' => 'array',
        'asked_at' => 'datetime',
    ];

    public function mockInterview(): BelongsTo
    {
        return $this->belongsTo(MockInterview::class, 'mock_interview_id');
    }

    public function response(): HasOne
    {
        return $this->hasOne(InterviewResponse::class, 'interview_question_id');
    }
}

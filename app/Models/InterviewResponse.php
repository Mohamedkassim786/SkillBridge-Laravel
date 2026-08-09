<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InterviewResponse extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'interview_question_id',
        'audio_path',
        'transcript',
        'duration',
        'word_count',
        'words_per_minute',
        'pause_count',
        'filler_word_count',
    ];

    protected $casts = [
        'duration' => 'integer',
        'word_count' => 'integer',
        'words_per_minute' => 'integer',
        'pause_count' => 'integer',
        'filler_word_count' => 'integer',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(InterviewQuestion::class, 'interview_question_id');
    }

    public function evaluation(): HasOne
    {
        return $this->hasOne(InterviewEvaluation::class, 'response_id');
    }
}

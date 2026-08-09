<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterviewEvaluation extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'response_id',
        'technical_score',
        'communication_score',
        'clarity_score',
        'confidence_score',
        'relevance_score',
        'structure_score',
        'grammar_score',
        'professionalism_score',
        'feedback',
        'improved_answer',
        'strengths',
        'weaknesses',
    ];

    protected $casts = [
        'technical_score' => 'integer',
        'communication_score' => 'integer',
        'clarity_score' => 'integer',
        'confidence_score' => 'integer',
        'relevance_score' => 'integer',
        'structure_score' => 'integer',
        'grammar_score' => 'integer',
        'professionalism_score' => 'integer',
        'strengths' => 'array',
        'weaknesses' => 'array',
    ];

    public function response(): BelongsTo
    {
        return $this->belongsTo(InterviewResponse::class, 'response_id');
    }
}

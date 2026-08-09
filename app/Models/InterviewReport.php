<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InterviewReport extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'mock_interview_id',
        'overall_score',
        'technical_score',
        'communication_score',
        'clarity_score',
        'confidence_score',
        'relevance_score',
        'structure_score',
        'grammar_score',
        'professionalism_score',
        'strengths',
        'weaknesses',
        'improvement_plan',
        'recommended_topics',
        'final_feedback',
    ];

    protected $casts = [
        'overall_score' => 'integer',
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
        'improvement_plan' => 'array',
        'recommended_topics' => 'array',
    ];

    public function mockInterview(): BelongsTo
    {
        return $this->belongsTo(MockInterview::class, 'mock_interview_id');
    }
}

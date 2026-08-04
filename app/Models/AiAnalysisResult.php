<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiAnalysisResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'ats_score',
        'keyword_matches',
        'missing_skills',
        'recommended_course_ids',
    ];

    protected $casts = [
        'keyword_matches' => 'array',
        'missing_skills' => 'array',
        'recommended_course_ids' => 'array',
    ];

    public function application()
    {
        return $this->belongsTo(JobApplication::class, 'application_id');
    }
}

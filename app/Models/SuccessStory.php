<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuccessStory extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'student_name',
        'photo_url',
        'company_name',
        'company_logo',
        'job_title',
        'salary_package',
        'course_title',
        'testimonial',
        'linkedin_url',
        'is_featured',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
    ];
}

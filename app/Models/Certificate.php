<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'uuid',
        'certificate_hash',
        'user_id',
        'course_version_id',
        'pdf_s3_key',
        'issued_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function courseVersion()
    {
        return $this->belongsTo(CourseVersion::class);
    }

    public function course()
    {
        return $this->hasOneThrough(
            Course::class,
            CourseVersion::class,
            'id',                // Foreign key on course_versions table...
            'id',                // Foreign key on courses table...
            'course_version_id', // Local key on certificates table...
            'course_id'          // Local key on course_versions table...
        );
    }

    public function getTitleAttribute()
    {
        return $this->course?->title ?? $this->courseVersion?->course?->title ?? 'Certified Software Engineer';
    }
}

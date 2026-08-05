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

    public function getCourseAttribute()
    {
        return $this->courseVersion?->course;
    }

    public function getTitleAttribute()
    {
        return $this->courseVersion?->course?->title ?? 'Certified Software Engineer';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'user_id',
        'course_id',
        'course_version_id',
        'cohort_id',
        'batch_id',
        'progress_percent',
        'status',
        'completed_at',
        'expires_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function cohort()
    {
        return $this->belongsTo(Batch::class, 'cohort_id');
    }
}

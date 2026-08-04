<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseVersion extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'course_id',
        'version_code',
        'description',
        'price',
        'level',
        'is_published',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('sort_order');
    }

    public function cohorts()
    {
        return $this->hasMany(CourseCohort::class);
    }
}

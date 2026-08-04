<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'course_version_id',
        'title',
        'sort_order',
    ];

    public function courseVersion()
    {
        return $this->belongsTo(CourseVersion::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('sort_order');
    }
}

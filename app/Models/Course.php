<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'category_id',
        'trainer_id',
        'title',
        'slug',
        'current_version_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function versions()
    {
        return $this->hasMany(CourseVersion::class);
    }

    public function currentVersion()
    {
        return $this->belongsTo(CourseVersion::class, 'current_version_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }
}

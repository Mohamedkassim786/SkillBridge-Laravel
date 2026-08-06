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
        'thumbnail_path',
        'current_version_id',
    ];

    public function getThumbnailAttribute(): string
    {
        if ($this->thumbnail_path) {
            if (str_starts_with($this->thumbnail_path, 'http://') || str_starts_with($this->thumbnail_path, 'https://')) {
                return $this->thumbnail_path;
            }

            return asset($this->thumbnail_path);
        }

        return 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?w=800&auto=format&fit=crop&q=80';
    }

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

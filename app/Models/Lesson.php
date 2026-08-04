<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'module_id',
        'media_asset_id',
        'title',
        'video_url',
        'duration',
        'sort_order',
        'is_free_preview',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function progress()
    {
        return $this->hasMany(LessonProgress::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LiveClassMaterial extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'live_class_materials';

    protected $fillable = [
        'live_class_id',
        'title',
        'type',
        'file_path',
        'external_url',
        'created_by',
    ];

    public function liveClass(): BelongsTo
    {
        return $this->belongsTo(LiveClass::class, 'live_class_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory, HasUlids;

    protected $fillable = [
        'name',
        'slug',
        'logo_path',
        'website',
        'tax_id',
        'billing_email',
        'description',
        'is_verified',
    ];

    public function members()
    {
        return $this->hasMany(CompanyMember::class);
    }

    public function jobPostings()
    {
        return $this->hasMany(JobPosting::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'description',
        'about',
        'mission',
        'culture',
        'size',
        'industry',
        'hq',
        'address',
        'website',
        'logo_path',
        'banner_path',
        'is_verified',
        'profile_template_id',
    ];

    public function perks(): HasMany
    {
        return $this->hasMany(CompanyPerk::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(CompanyGallery::class);
    }
}

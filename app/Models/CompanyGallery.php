<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyGallery extends Model
{
    protected $fillable = [
        'company_id',
        'image_path',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}

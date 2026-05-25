<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyPerk extends Model
{
    protected $fillable = [
        'company_id',
        'perk_name',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}

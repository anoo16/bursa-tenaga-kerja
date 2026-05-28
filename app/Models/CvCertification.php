<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvCertification extends Model
{
    protected $fillable=[
        'cv_profile_id',
        'name',
        'issuer',
        'year',
        'credential_url',
        'sort_order'
    ];

    public function profile()
    {
        return $this->belongsTo(
            CvProfile::class,
            'cv_profile_id'
        );
    }
}

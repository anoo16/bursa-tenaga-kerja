<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvSkill extends Model
{
    protected $fillable=[
        'cv_profile_id',
        'name',
        'level',
        'category',
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

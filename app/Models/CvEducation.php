<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvEducation extends Model
{
    protected $table = "cv_educations";
    
    protected $fillable=[
        'cv_profile_id',
        'institution',
        'degree',
        'field_of_study',
        'start_year',
        'end_year',
        'gpa',
        'description',
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

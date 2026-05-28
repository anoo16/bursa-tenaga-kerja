<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class CvEducation extends Model {
    protected $fillable = [
        'cv_profile_id','institution','degree','field_of_study',
        'start_year','end_year','gpa','description','sort_order'
    ];
}

class CvSkill extends Model {
    protected $fillable = [
        'cv_profile_id','name','level','category','sort_order'
    ];
}

class CvCertification extends Model {
    protected $fillable = [
        'cv_profile_id','name','issuer','year','credential_url','sort_order'
    ];
}

class CvTemplate extends Model {
    protected $fillable = [
        'slug','name','description','preview_image','is_active'
    ];
}

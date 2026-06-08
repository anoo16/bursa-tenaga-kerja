<?php

namespace App\Models;

use App\Models\CvProfile;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Certification;
use App\Models\Education;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_verified',
        'approval_status',
        'rejected_reason',
        'phone',
        'birth_date',
        'education',
        'company_name',
        'npwp',
        'npwp_file',
        'business_license_file',
        'pic_authorization_file',
        'photo',
        'summary',
        'location',
        'headline',
        'linkedin',
        'github',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'birth_date' => 'date',
        ];
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function skills()
    {
        return $this->hasMany(Skill::class);
    }

    public function certifications()
    {
        return $this->hasMany(Certification::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }

    public function cvProfile()
    {
        return $this->hasOne(CvProfile::class);
    }
    public function applications()
    {
    return $this->hasMany(JobApplication::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CvProfile extends Model
{
    protected $fillable = [
        'user_id', 'full_name', 'job_title', 'email', 'phone',
        'location', 'website', 'linkedin', 'summary',
        'photo', 'template_id', 'primary_color',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function experiences(): HasMany
    {
        return $this->hasMany(CvExperience::class)->orderBy('sort_order');
    }

    public function educations(): HasMany
    {
        return $this->hasMany(CvEducation::class)->orderBy('sort_order');
    }

    public function skills(): HasMany
    {
        return $this->hasMany(CvSkill::class)->orderBy('sort_order');
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(CvCertification::class)->orderBy('sort_order');
    }
}

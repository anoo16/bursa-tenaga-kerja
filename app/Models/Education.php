<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'user_id',
        'level',
        'major',
        'school',
        'graduation_year',
    ];
}
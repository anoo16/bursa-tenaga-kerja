<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CvTemplate extends Model
{
    protected $fillable=[
        'slug',
        'name',
        'description',
        'preview_image',
        'is_active'
    ];
}
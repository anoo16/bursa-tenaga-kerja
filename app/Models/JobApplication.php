<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
    'job_id',
    'user_id',
    'status',
    'cover_letter',
    'cv_file',
    'portfolio_file',
    'portfolio_link',
    'applied_at',
    ];

    protected $casts = [
        'applied_at' => 'datetime', // ← tambah
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
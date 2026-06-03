<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    protected $fillable=[
        // Data yang boleh disimpan
        'posisi',
        'kategori',
        'gaji',
        'deadline',
        'tanggung_jawab',
        'kualifikasi',
        'status'
    ];

    protected $casts=[
        //Mengubah data JSON menjadi array otomatis
        'tanggung_jawab'=>'array',
        'kualifikasi'=>'array'
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}

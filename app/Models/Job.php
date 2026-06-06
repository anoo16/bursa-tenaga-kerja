<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        // Data yang boleh disimpan
        'company_id',
        'posisi',
        'kategori',
        'jenis_bidang',
        'gaji_minimum',
        'gaji_maksimum',
        'deadline',
        'tanggung_jawab',
        'kualifikasi',
        'status'
    ];

    protected $casts = [
        // Mengubah data JSON menjadi array otomatis
        'tanggung_jawab' => 'array',
        'kualifikasi' => 'array'
    ];

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }
}

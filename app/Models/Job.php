<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        // Data yang boleh disimpan
        'posisi',
        'kategori',
        'jenis_bidang',
        'gaji_min_angka',   // ← tambah
        'gaji_max_angka',   // ← tambah
        'gaji',
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

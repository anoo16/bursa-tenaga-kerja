<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        // Bersihkan dulu agar tidak duplikat saat dijalankan ulang
        DB::table('job_applications')->truncate();

        DB::table('job_applications')->insert([

            // ── Lamaran milik Aristo (id 1001) ──
            // Ini yang akan muncul di halaman "Lamaran Saya" saat login sebagai aristo@gmail.com

            [
                'user_id'    => 1001,
                'job_id'     => 1001,
                'status'     => 'REVIEW',
                'stage'      => 'BARU',
                'cover_letter' => 'Saya tertarik dengan posisi Lead Experience Architect dan siap berkontribusi maksimal.',
                'applied_at' => now()->subDays(10),
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(2),
            ],

            [
                'user_id'    => 1001,
                'job_id'     => 1002,
                'status'     => 'INTERVIEW',
                'stage'      => 'INTERVIEW',
                'cover_letter' => 'Saya memiliki pengalaman React lebih dari 3 tahun.',
                'applied_at' => now()->subDays(8),
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(1),
            ],

            [
                'user_id'    => 1001,
                'job_id'     => 1003,
                'status'     => 'DITERIMA',
                'stage'      => 'DITERIMA',
                'cover_letter' => 'Saya memiliki passion di bidang growth strategy.',
                'applied_at' => now()->subDays(15),
                'created_at' => now()->subDays(15),
                'updated_at' => now()->subDays(3),
            ],

            [
                'user_id'    => 1001,
                'job_id'     => 1004,
                'status'     => 'DITOLAK',
                'stage'      => 'DITOLAK',
                'cover_letter' => 'Saya berpengalaman video editing menggunakan Premiere Pro.',
                'applied_at' => now()->subDays(20),
                'created_at' => now()->subDays(20),
                'updated_at' => now()->subDays(5),
            ],

            // ── Lamaran dari user lain (untuk halaman Pelamar Masuk recruiter) ──

            [
                'user_id'    => 1002,
                'job_id'     => 1001,
                'status'     => 'BARU',
                'stage'      => 'BARU',
                'cover_letter' => 'Saya Pascalita, tertarik dengan posisi ini.',
                'applied_at' => now()->subDays(3),
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],

            [
                'user_id'    => 1003,
                'job_id'     => 1002,
                'status'     => 'REVIEW',
                'stage'      => 'BARU',
                'cover_letter' => 'Saya Evan, siap bergabung sebagai React Engineer.',
                'applied_at' => now()->subDays(5),
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(1),
            ],

            [
                'user_id'    => 1004,
                'job_id'     => 1003,
                'status'     => 'DITERIMA',
                'stage'      => 'DITERIMA',
                'cover_letter' => 'Saya Chelsea, berpengalaman di bidang creative management.',
                'applied_at' => now()->subDays(7),
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(1),
            ],

        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobApplication;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        JobApplication::insert([

            [
                'user_id' => 1001,
                'job_id' => 1001,
                'status' => 'BARU',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 1002,
                'job_id' => 1002,
                'status' => 'INTERVIEW',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 1003,
                'job_id' => 1003,
                'status' => 'DITOLAK',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'user_id' => 1004,
                'job_id' => 1004,
                'status' => 'DITERIMA',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
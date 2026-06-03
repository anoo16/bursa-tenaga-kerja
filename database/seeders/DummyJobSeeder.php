<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;

class DummyJobSeeder extends Seeder
{
    public function run(): void
    {
        Job::insert([

            [
                'id' => 1001,
                'posisi' => 'Lead Experience Architect',
                'kategori' => 'Design',
                'gaji' => '8-10 Juta',

                'tanggung_jawab' => json_encode([
                    'Mendesain UI/UX'
                ]),

                'kualifikasi' => json_encode([
                    'Figma'
                ]),

                'status' => 'buka',
            ],

            [
                'id' => 1002,
                'posisi' => 'Senior React Engineer',
                'kategori' => 'IT',
                'gaji' => '10-15 Juta',

                'tanggung_jawab' => json_encode([
                    'Membangun aplikasi React'
                ]),

                'kualifikasi' => json_encode([
                    'React'
                ]),

                'status' => 'buka',
            ],

            [
                'id' => 1003,
                'posisi' => 'Growth Lead',
                'kategori' => 'Management',
                'gaji' => '12-18 Juta',

                'tanggung_jawab' => json_encode([
                    'Growth Strategy'
                ]),

                'kualifikasi' => json_encode([
                    'Leadership'
                ]),

                'status' => 'buka',
            ],

            [
                'id' => 1004,
                'posisi' => 'Video Editor',
                'kategori' => 'Creative',
                'gaji' => '5-8 Juta',

                'tanggung_jawab' => json_encode([
                    'Video Editing'
                ]),

                'kualifikasi' => json_encode([
                    'Premiere Pro'
                ]),

                'status' => 'buka',
            ],

        ]);
    }
}
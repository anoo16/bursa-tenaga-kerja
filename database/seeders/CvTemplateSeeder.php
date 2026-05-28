<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CvTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'slug'          => 'modern',
                'name'          => 'Modern Blue',
                'description'   => 'Desain modern dengan aksen biru, cocok untuk IT & tech',
                'preview_image' => 'templates/modern.png',
                'is_active'     => true,
            ],
            [
                'slug'          => 'classic',
                'name'          => 'Classic Elegant',
                'description'   => 'Desain klasik hitam putih, cocok untuk profesional formal',
                'preview_image' => 'templates/classic.png',
                'is_active'     => true,
            ],
            [
                'slug'          => 'minimal',
                'name'          => 'Minimal Clean',
                'description'   => 'Bersih dan minimalis, menonjolkan konten tanpa distraksi',
                'preview_image' => 'templates/minimal.png',
                'is_active'     => true,
            ],
        ];

        DB::table('cv_templates')->insert($templates);
    }
}

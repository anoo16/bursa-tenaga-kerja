<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = Company::create([
            'name' => '',
            'is_verified' => false,
            'description' => '',
            'about' => '',
            'mission' => '',
            'culture' => '',
            'size' => '',
            'industry' => '',
            'hq' => '',
            'address' => '',
            'website' => '',
            'logo_path' => null,
            'banner_path' => null,
        ]);
        
        // We can add some empty galleries or placeholder paths later if needed.
    }
}

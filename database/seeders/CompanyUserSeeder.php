<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan akun perusahaan (role_id = 2) dibuat
        User::updateOrCreate(
            ['email' => 'bongkarturet@gmail.com'],
            [
                'name' => 'PT Bongkar Turet',
                'password' => Hash::make('pushkiri'),
                'role_id' => 2,
                'is_verified' => true,
                'approval_status' => 'approved',
                'company_name' => 'PT Bongkar Turet'
            ]
        );
    }
}

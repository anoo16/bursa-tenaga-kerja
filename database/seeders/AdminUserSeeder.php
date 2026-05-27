<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $adminName = env('ADMIN_NAME');
        $adminEmail = env('ADMIN_EMAIL');
        $adminPassword = env('ADMIN_PASSWORD');

        if (!$adminName || !$adminEmail || !$adminPassword) {
            throw new RuntimeException(
                'ADMIN_NAME, ADMIN_EMAIL, dan ADMIN_PASSWORD wajib diisi pada file .env sebelum menjalankan AdminUserSeeder.'
            );
        }

        User::updateOrCreate(
            [
                'email' => $adminEmail,
            ],
            [
                'name' => $adminName,
                'password' => $adminPassword,
                'role_id' => 1,
                'is_verified' => true,
                'approval_status' => 'approved',
                'rejected_reason' => null,
                'phone' => null,
                'birth_date' => null,
                'education' => null,
                'company_name' => null,
                'npwp' => null,
                'npwp_file' => null,
                'business_license_file' => null,
                'pic_authorization_file' => null,
            ]
        );
    }
}
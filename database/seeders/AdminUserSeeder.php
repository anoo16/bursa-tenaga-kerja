<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => env('ADMIN_NAME', 'Aku Admin Utama🤑'),
                'email' => env('ADMIN_EMAIL'),
                'password' => env('ADMIN_PASSWORD'),
            ],
            [
                'name' => env('ADMIN2_NAME', 'Admin Kelompok'),
                'email' => env('ADMIN2_EMAIL'),
                'password' => env('ADMIN2_PASSWORD'),
            ],
        ];

        foreach ($admins as $admin) {

            if (empty($admin['email']) || empty($admin['password'])) {
                continue;
            }

            User::updateOrCreate(
                [
                    'email' => $admin['email'],
                ],
                [
                    'name' => $admin['name'],
                    'password' => $admin['password'],
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
}

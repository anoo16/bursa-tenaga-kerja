<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'name' => 'PT BONGKAR TURET',
                'email' => 'mobilelegend@moontoon.com',
                'password' => 'mainsampegila',
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
                    'role_id' => 2,
                    'is_verified' => true,
                    'email_verified' => true,
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

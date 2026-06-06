<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'PT BONGKAR TURET',
            'email' => 'mobilelegend@moontoon.com',
            'password' => 'mainsampegila',
            'role_id' => 2,
            'is_verified' =>true,
        ]);

        $this->call([
            AdminUserSeeder::class,
            CompanyUserSeeder::class,
            DummyApplicantSeeder::class,
            DummyJobSeeder::class,
            JobApplicationSeeder::class,

        ]);
    }
}

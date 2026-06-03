<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DummyApplicantSeeder extends Seeder
{
    public function run(): void
    {
        User::insert([

            [
                'id' => 1001,
                'name' => 'Aristo Kaunang',
                'email' => 'aristo@gmail.com',
                'password' => Hash::make('password'),
                'summary' => 'Senior UI Designer',
                'location' => 'Manado',
            ],

            [
                'id' => 1002,
                'name' => 'Pascalita Sinedu',
                'email' => 'pascalita@gmail.com',
                'password' => Hash::make('password'),
                'summary' => 'Fullstack Developer',
                'location' => 'Manado',
            ],

            [
                'id' => 1003,
                'name' => 'Evan Kapoh',
                'email' => 'evan@gmail.com',
                'password' => Hash::make('password'),
                'summary' => 'Product Manager',
                'location' => 'Tomohon',
            ],

            [
                'id' => 1004,
                'name' => 'Chelsea Paduli',
                'email' => 'chelsea@gmail.com',
                'password' => Hash::make('password'),
                'summary' => 'Creative Director',
                'location' => 'Bitung',
            ],

        ]);
    }
}
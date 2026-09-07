<?php

namespace Database\Seeders;

use Base\Models\User\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email'             => 'admin@teste.com'],
            [
                'name'           => 'admin',
                'password'       => env('DEFAULT_PASSWORD'),
                'verify_at'      => now(),
                'remember_token' => null,
            ]
        );
    }
}

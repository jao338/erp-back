<?php

namespace Database\Seeders;

use ERP\Models\Client\Client;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Client::factory()->count(20)->create();
    }
}

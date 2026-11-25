<?php

namespace Database\Seeders;

use ERP\Models\Supplier\Supplier;
use ERP\Models\Person\Person;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupplierSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Supplier::factory()
            ->count(10)
            ->create();
    }
}

<?php

namespace Database\Seeders;

use ERP\Models\Product\Product;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Product::factory()->count(10)->create();
    }
}

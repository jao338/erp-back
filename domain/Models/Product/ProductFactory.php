<?php

namespace ERP\Models\Product;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected static ?string $password;
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'average_cost'      => fake()->randomFloat(2, 1, 5000),
            'sale_price'        => fake()->randomFloat(2, 1, 10000),
            'amount'            => fake()->numberBetween(1,50),
        ];
    }
}

<?php

namespace ERP\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected static ?string $password;
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'cnpj'              => fake('pt_BR')->cnpj(false),
            'telephone'         => fake('pt_BR')->cellphone(false),
        ];
    }
}

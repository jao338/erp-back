<?php

namespace ERP\Models\Client;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    protected static ?string $password;
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'cpf'               => fake('pt_BR')->cpf(false),
            'telephone'         => fake('pt_BR')->cellphone(false),
        ];
    }
}

<?php

namespace ERP\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected static ?string $password;
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'remember_token'    => null,
            'password'          => env('DEFAULT_PASSWORD'),
        ];
    }
}

<?php

namespace ERP\Models\Person;

use ERP\Enums\PersonType;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        return [
            'person_type' => PersonType::INDIVIDUAL->value,
            'name'        => fake()->name(),
            'cpf'         => fake('pt_BR')->cpf(false),
            'email'       => fake()->safeEmail(),
            'telephone'   => fake()->numerify('0###########'),
        ];
    }
}

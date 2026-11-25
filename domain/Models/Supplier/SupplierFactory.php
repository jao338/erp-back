<?php

namespace ERP\Models\Supplier;

use ERP\Models\Person\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected static ?string $password;
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'person_id' => Person::factory(),
        ];
    }
}

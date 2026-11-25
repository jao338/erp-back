<?php

namespace ERP\Models\Person;

use ERP\Enums\PersonType;
use ERP\Models\Supplier\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Person extends Model
{
    use HasFactory;

    protected $table = 'person';

    protected $fillable = [
        'uuid',
        'person_type',
        'name',
        'cpf',
        'cnpj',
        'email',
        'telephone',
    ];

    protected function casts(): array
    {
        return [
            'person_type' => PersonType::class,
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }

    public function supplier(): HasOne
    {
        return $this->hasOne(Supplier::class);
    }

    protected static function newFactory()
    {
        return PersonFactory::new();
    }

    protected static function booted(): void
    {
        static::creating(function (self $person) {
            if (empty($person->uuid)) {
                $person->uuid = (string) Str::uuid();
            }
        });
    }
}

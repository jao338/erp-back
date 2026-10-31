<?php

namespace ERP\Models\Supplier;

use ERP\Enums\PersonType;

final readonly class SupplierDTO
{
    public function __construct(
        public PersonType $personType,
        public string $name,
        public ?string $cpf,
        public ?string $cnpj,
        public ?string $email,
        public ?string $telephone,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            personType: PersonType::from((int) $data['tipo']),
            name: $data['nome'],
            cpf: $data['cpf'] ?? null,
            cnpj: $data['cnpj'] ?? null,
            email: $data['email'] ?? null,
            telephone: $data['telefone'] ?? null,
        );
    }

    public function toPersonArray(): array
    {
        return [
            'person_type' => $this->personType->value,
            'name'        => $this->name,
            'cpf'         => $this->cpf,
            'cnpj'        => $this->cnpj,
            'email'       => $this->email,
            'telephone'   => $this->telephone,
        ];
    }

    public function toSupplierArray(int $personId): array
    {
        return ['person_id' => $personId];
    }
}

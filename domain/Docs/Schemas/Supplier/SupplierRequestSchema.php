<?php

namespace ERP\Docs\Schemas\Supplier;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SupplierRequest',
    required: ['tipo', 'nome']
)]
class SupplierRequestSchema
{
    #[OA\Property(description: 'Tipo da pessoa: 1 = pessoa física, 2 = pessoa jurídica', type: 'integer', enum: [1, 2], example: 2)]
    public int $tipo;

    #[OA\Property(description: 'Nome do fornecedor', minLength: 3, maxLength: 255, example: 'Fornecedor de café')]
    public string $nome;

    #[OA\Property(description: 'CPF, obrigatório para pessoa física e incompatível com CNPJ', minLength: 11, maxLength: 11, nullable: true, example: '12345678901')]
    public ?string $cpf;

    #[OA\Property(description: 'CNPJ, obrigatório para pessoa jurídica e incompatível com CPF', minLength: 14, maxLength: 14, nullable: true, example: '12345678000190')]
    public ?string $cnpj;

    #[OA\Property(description: 'E-mail da pessoa', format: 'email', nullable: true, example: 'contato@fornecedor.com')]
    public ?string $email;

    #[OA\Property(description: 'Telefone da pessoa', nullable: true, example: '5511999999999')]
    public ?string $telefone;
}

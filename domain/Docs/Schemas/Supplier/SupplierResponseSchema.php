<?php

namespace ERP\Docs\Schemas\Supplier;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SupplierResponse',
    required: ['tipo', 'nome', 'criado_em', 'atualizado_em', 'uuid']
)]
class SupplierResponseSchema
{
    #[OA\Property(description: 'Tipo da pessoa: 1 = pessoa física, 2 = pessoa jurídica', type: 'integer', enum: [1, 2], example: 2)]
    public int $tipo;

    #[OA\Property(description: 'Nome do fornecedor', example: 'Fornecedor de café')]
    public string $nome;

    #[OA\Property(description: 'CPF da pessoa', maxLength: 11, nullable: true, example: '12345678901')]
    public ?string $cpf;

    #[OA\Property(description: 'CNPJ da pessoa', maxLength: 14, nullable: true, example: '12345678000190')]
    public ?string $cnpj;

    #[OA\Property(description: 'E-mail da pessoa', format: 'email', nullable: true, example: 'contato@fornecedor.com')]
    public ?string $email;

    #[OA\Property(description: 'Telefone da pessoa', nullable: true, example: '5511999999999')]
    public ?string $telefone;

    #[OA\Property(description: 'Data de criação do fornecedor', format: 'date-time', example: '2026-01-15T10:30:00Z')]
    public string $criado_em;

    #[OA\Property(description: 'Data da última atualização do fornecedor', format: 'date-time', example: '2026-01-15T10:30:00Z')]
    public string $atualizado_em;

    #[OA\Property(description: 'Identificador único do fornecedor', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000')]
    public string $uuid;
}

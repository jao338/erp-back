<?php

namespace ERP\Docs\Schemas\Supplier;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SupplierResponse',
    required: ['nome', 'cnpj', 'email', 'telephone', 'criado_em', 'atualizado_em', 'uuid']
)]
class SupplierResponseSchema
{
    #[OA\Property(description: 'Nome do fornecedor', example: 'Fornecedor de café')]
    public string $nome;

    #[OA\Property(description: 'CNPJ do fornecedor', maxLength: 14, example: '12345678000190')]
    public string $cnpj;

    #[OA\Property(description: 'E-mail do fornecedor', format: 'email', example: 'contato@fornecedor.com')]
    public string $email;

    #[OA\Property(description: 'Telefone do fornecedor', example: 5511999999999)]
    public int $telephone;

    #[OA\Property(description: 'Data de criação do fornecedor', format: 'date-time', example: '2026-01-15T10:30:00Z')]
    public string $criado_em;

    #[OA\Property(description: 'Data da última atualização do fornecedor', format: 'date-time', example: '2026-01-15T10:30:00Z')]
    public string $atualizado_em;

    #[OA\Property(description: 'Identificador único do fornecedor', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000')]
    public string $uuid;
}

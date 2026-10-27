<?php

namespace ERP\Docs\Schemas\Sale;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SaleResponse',
    required: ['uuid', 'criado_em', 'atualizado_em', 'ativo', 'lucro', 'cliente', 'itens']
)]
class SaleResponseSchema
{
    #[OA\Property(description: 'Identificador único da venda', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000')]
    public string $uuid;

    #[OA\Property(description: 'Data de criação da venda', format: 'date-time', example: '2026-01-15T10:30:00Z')]
    public string $criado_em;

    #[OA\Property(description: 'Data da última atualização da venda', format: 'date-time', example: '2026-01-15T10:30:00Z')]
    public string $atualizado_em;

    #[OA\Property(description: 'Indica se a venda está ativa', example: true)]
    public bool $ativo;

    #[OA\Property(description: 'Lucro total da venda', example: 25.6)]
    public float $lucro;

    #[OA\Property(description: 'Nome do cliente', nullable: true, example: 'Cliente XPTO')]
    public ?string $cliente;

    #[OA\Property(type: 'array', items: new OA\Items(ref: SaleItemResponseSchema::class))]
    public array $itens;
}

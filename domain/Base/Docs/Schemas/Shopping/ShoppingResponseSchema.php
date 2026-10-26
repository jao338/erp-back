<?php

namespace Base\Base\Docs\Schemas\Shopping;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ShoppingResponse',
    required: ['uuid', 'total', 'fornecedor', 'items', 'criado_em', 'atualizado_em']
)]
class ShoppingResponseSchema
{
    #[OA\Property(description: 'Identificador único da compra', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000')]
    public string $uuid;

    #[OA\Property(description: 'Valor total da compra', example: 125)]
    public float $total;

    #[OA\Property(description: 'Nome do fornecedor', nullable: true, example: 'Fornecedor XPTO')]
    public ?string $fornecedor;

    #[OA\Property(type: 'array', items: new OA\Items(ref: ShoppingItemResponseSchema::class))]
    public array $items;

    #[OA\Property(description: 'Data de criação da compra', format: 'date-time', example: '2026-01-15T10:30:00Z')]
    public string $criado_em;

    #[OA\Property(description: 'Data da última atualização da compra', format: 'date-time', example: '2026-01-15T10:30:00Z')]
    public string $atualizado_em;
}

<?php

namespace Base\Base\Docs\Schemas\Shopping;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ShoppingItemResponse',
    required: ['uuid', 'preco_unitario', 'subtotal', 'produto', 'produto_uuid']
)]
class ShoppingItemResponseSchema
{
    #[OA\Property(description: 'Identificador único do item', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000')]
    public string $uuid;

    #[OA\Property(description: 'Preço unitário do produto', example: 12.5)]
    public float $preco_unitario;

    #[OA\Property(description: 'Subtotal do item', example: 125)]
    public float $subtotal;

    #[OA\Property(description: 'Nome do produto', nullable: true, example: 'Café especial')]
    public ?string $produto;

    #[OA\Property(description: 'UUID do produto', nullable: true, format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000')]
    public ?string $produto_uuid;
}

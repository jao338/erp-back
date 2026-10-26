<?php

namespace Base\Base\Docs\Schemas\Sale;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SaleItemResponse',
    required: ['uuid', 'produto', 'quantidade', 'preco_unitario', 'custo_unitario', 'subtotal', 'lucro']
)]
class SaleItemResponseSchema
{
    #[OA\Property(description: 'Identificador único do item', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000')]
    public string $uuid;

    #[OA\Property(description: 'Nome do produto', nullable: true, example: 'Café especial')]
    public ?string $produto;

    #[OA\Property(description: 'Quantidade vendida', example: 2)]
    public int $quantidade;

    #[OA\Property(description: 'Preço unitário de venda', example: 18.9)]
    public float $preco_unitario;

    #[OA\Property(description: 'Custo unitário do produto', example: 12.5)]
    public float $custo_unitario;

    #[OA\Property(description: 'Subtotal do item', example: 37.8)]
    public float $subtotal;

    #[OA\Property(description: 'Lucro obtido no item', example: 12.8)]
    public float $lucro;
}

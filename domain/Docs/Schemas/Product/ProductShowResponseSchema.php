<?php

namespace ERP\Docs\Schemas\Product;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ProductShowResponse',
    required: ['data'],
    example: [
        'data' => [
            'nome' => 'Café especial',
            'custo_medio' => 12.5,
            'preco_venda' => 18.9,
            'quantidade' => 100,
            'criado_em' => '2026-01-15T10:30:00Z',
            'atualizado_em' => '2026-01-15T10:30:00Z',
            'uuid' => '550e8400-e29b-41d4-a716-446655440000',
        ],
    ]
)]
class ProductShowResponseSchema
{
    #[OA\Property(ref: ProductResponseSchema::class)]
    public ProductResponseSchema $data;
}

<?php

namespace ERP\Docs\Schemas\Shopping;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ShoppingShowResponse',
    required: ['data'],
    example: [
        'data' => [
            'uuid' => '550e8400-e29b-41d4-a716-446655440000',
            'total' => 125,
            'fornecedor' => 'Fornecedor XPTO',
            'items' => [
                [
                    'uuid' => '660e8400-e29b-41d4-a716-446655440000',
                    'preco_unitario' => 12.5,
                    'subtotal' => 125,
                    'produto' => 'Café especial',
                    'produto_uuid' => '770e8400-e29b-41d4-a716-446655440000',
                ],
            ],
            'criado_em' => '2026-01-15T10:30:00Z',
            'atualizado_em' => '2026-01-15T10:30:00Z',
        ],
    ]
)]
class ShoppingShowResponseSchema
{
    #[OA\Property(ref: ShoppingResponseSchema::class)]
    public ShoppingResponseSchema $data;
}

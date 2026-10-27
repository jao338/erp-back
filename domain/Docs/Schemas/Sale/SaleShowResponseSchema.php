<?php

namespace ERP\Docs\Schemas\Sale;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SaleShowResponse',
    required: ['data'],
    example: [
        'data' => [
            'uuid' => '550e8400-e29b-41d4-a716-446655440000',
            'criado_em' => '2026-01-15T10:30:00Z',
            'atualizado_em' => '2026-01-15T10:30:00Z',
            'ativo' => true,
            'lucro' => 25.6,
            'cliente' => 'Cliente XPTO',
            'itens' => [
                [
                    'uuid' => '660e8400-e29b-41d4-a716-446655440000',
                    'produto' => 'Café especial',
                    'quantidade' => 2,
                    'preco_unitario' => 18.9,
                    'custo_unitario' => 12.5,
                    'subtotal' => 37.8,
                    'lucro' => 12.8,
                ],
            ],
        ],
    ]
)]
class SaleShowResponseSchema
{
    #[OA\Property(ref: SaleResponseSchema::class)]
    public SaleResponseSchema $data;
}

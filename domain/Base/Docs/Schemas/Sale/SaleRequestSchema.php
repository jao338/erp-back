<?php

namespace Base\Base\Docs\Schemas\Sale;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'SaleRequest',
    required: ['cliente_uuid', 'itens']
)]
class SaleRequestSchema
{
    #[OA\Property(description: 'UUID do cliente', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000')]
    public string $cliente_uuid;

    #[OA\Property(
        type: 'array',
        minItems: 1,
        items: new OA\Items(
            type: 'object',
            required: ['produto_uuid', 'quantidade', 'preco_unitario'],
            properties: [
                new OA\Property(property: 'produto_uuid', description: 'UUID do produto', type: 'string', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000'),
                new OA\Property(property: 'quantidade', description: 'Quantidade vendida', type: 'integer', minimum: 1, example: 2),
                new OA\Property(property: 'preco_unitario', description: 'Preço unitário de venda', type: 'number', format: 'float', minimum: 0, exclusiveMinimum: true, example: 18.9),
            ]
        )
    )]
    public array $itens;
}

<?php

namespace Base\Base\Docs\Schemas\Shopping;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ShoppingRequest',
    required: ['fornecedor_uuid', 'itens']
)]
class ShoppingRequestSchema
{
    #[OA\Property(description: 'UUID do fornecedor', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000')]
    public string $fornecedor_uuid;

    #[OA\Property(
        type: 'array',
        minItems: 1,
        items: new OA\Items(
            type: 'object',
            required: ['produto_uuid', 'quantidade', 'preco_unitario'],
            properties: [
                new OA\Property(property: 'produto_uuid', description: 'UUID do produto', type: 'string', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000'),
                new OA\Property(property: 'quantidade', description: 'Quantidade comprada', type: 'integer', minimum: 1, example: 10),
                new OA\Property(property: 'preco_unitario', description: 'Preço unitário de compra', type: 'number', format: 'float', minimum: 0, exclusiveMinimum: true, example: 12.5),
            ]
        )
    )]
    public array $itens;
}

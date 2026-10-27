<?php

namespace ERP\Docs\Schemas\Shopping;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ShoppingCollectionResponse',
    required: ['data', 'links', 'meta']
)]
class ShoppingCollectionResponseSchema
{
    #[OA\Property(type: 'array', items: new OA\Items(ref: ShoppingResponseSchema::class))]
    public array $data;

    #[OA\Property(
        type: 'object',
        properties: [
            new OA\Property(property: 'first', type: 'string', nullable: true, example: 'http://localhost/api/shopping?page=1'),
            new OA\Property(property: 'last', type: 'string', nullable: true, example: 'http://localhost/api/shopping?page=5'),
            new OA\Property(property: 'prev', type: 'string', nullable: true, example: null),
            new OA\Property(property: 'next', type: 'string', nullable: true, example: 'http://localhost/api/shopping?page=2'),
        ]
    )]
    public object $links;

    #[OA\Property(
        type: 'object',
        properties: [
            new OA\Property(property: 'current_page', type: 'integer', example: 1),
            new OA\Property(property: 'from', type: 'integer', nullable: true, example: 1),
            new OA\Property(property: 'last_page', type: 'integer', example: 5),
            new OA\Property(property: 'path', type: 'string', example: 'http://localhost/api/shopping'),
            new OA\Property(property: 'per_page', type: 'integer', example: 20),
            new OA\Property(property: 'to', type: 'integer', nullable: true, example: 20),
            new OA\Property(property: 'total', type: 'integer', example: 100),
        ]
    )]
    public object $meta;
}

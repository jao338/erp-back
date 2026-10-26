<?php

namespace Base\Base\Docs\Schemas\Client;

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'ClientLookupResponse', required: ['data'])]
class ClientLookupResponseSchema
{
    #[OA\Property(
        type: 'array',
        items: new OA\Items(
            type: 'object',
            required: ['value', 'label'],
            properties: [
                new OA\Property(property: 'value', type: 'string', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000'),
                new OA\Property(property: 'label', type: 'string', example: 'João da Silva'),
            ]
        )
    )]
    public array $data;
}

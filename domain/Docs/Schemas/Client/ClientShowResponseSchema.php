<?php

namespace ERP\Docs\Schemas\Client;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ClientShowResponse',
    required: ['data'],
    example: [
        'data' => [
            'nome' => 'João da Silva',
            'documento' => '12345678901',
            'email' => 'joao@example.com',
            'telefone' => 5511999999999,
            'criado_em' => '2026-01-15T10:30:00Z',
            'atualizado_em' => '2026-01-15T10:30:00Z',
            'uuid' => '550e8400-e29b-41d4-a716-446655440000',
        ],
    ]
)]
class ClientShowResponseSchema
{
    #[OA\Property(ref: ClientResponseSchema::class)]
    public ClientResponseSchema $data;
}

<?php

namespace Base\Base\Docs\Schemas\Client;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ClientResponse',
    required: ['nome', 'documento', 'email', 'telefone', 'criado_em', 'atualizado_em', 'uuid']
)]
class ClientResponseSchema
{
    #[OA\Property(description: 'Nome do cliente', example: 'João da Silva')]
    public string $nome;

    #[OA\Property(description: 'CPF do cliente', maxLength: 11, example: '12345678901')]
    public string $documento;

    #[OA\Property(description: 'E-mail do cliente', format: 'email', example: 'joao@example.com')]
    public string $email;

    #[OA\Property(description: 'Telefone do cliente', example: 5511999999999)]
    public int $telefone;

    #[OA\Property(description: 'Data de criação do cliente', format: 'date-time', example: '2026-01-15T10:30:00Z')]
    public string $criado_em;

    #[OA\Property(description: 'Data da última atualização do cliente', format: 'date-time', example: '2026-01-15T10:30:00Z')]
    public string $atualizado_em;

    #[OA\Property(description: 'Identificador único do cliente', format: 'uuid', example: '550e8400-e29b-41d4-a716-446655440000')]
    public string $uuid;
}

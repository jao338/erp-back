<?php

namespace ERP\Docs\Schemas\Auth;

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'AuthLoginResponseSchema')]
class AuthLoginResponseSchema
{
    #[OA\Property(
        description: 'E-mail do usuário autenticado',
        example: 'joao@email.com'
    )]
    public string $email;

    #[OA\Property(
        description: 'Nome do usuário',
        example: 'João Pedro'
    )]
    public string $nome;

    #[OA\Property(
        description: 'Identificador único do usuário',
        type: 'string',
        format: 'uuid',
        example: '550e8400-e29b-41d4-a716-446655440000'
    )]
    public string $uuid;

    #[OA\Property(
        description: 'Token Sanctum para autenticação. Pode ser nulo quando a autenticação ocorre via sessão.',
        nullable: true,
        example: '1|xKgM4....'
    )]
    public ?string $token;
}

<?php

namespace Base\Base\Docs\Schemas\Auth;

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
        description: 'Token Bearer utilizado para autenticação',
        example: '1|xKgM4....'
    )]
    public string $token;
}
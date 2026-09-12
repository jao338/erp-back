<?php

namespace Base\Base\Docs\Schemas\Auth;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'AuthLoginRequestSchema',
    required: ['email', 'password']
)]
class AuthLoginRequestSchema
{
    #[OA\Property(
        description: 'E-mail do usuário',
        type: 'string',
        format: 'email',
        example: 'joao@email.com'
    )]
    public string $email;

    #[OA\Property(
        description: 'Senha do usuário',
        type: 'string',
        format: 'password',
        minLength: 8,
        example: '12345678'
    )]
    public string $password;
}
<?php

namespace Base\Base\Docs\Schemas\Auth;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'AuthRegisterRequestSchema',
    required: [
        'name',
        'email',
        'password',
        'confirm_password',
    ]
)]
class AuthRegisterRequestSchema
{
    #[OA\Property(
        description: 'Nome do usuário',
        type: 'string',
        example: 'João Pedro'
    )]
    public string $name;

    #[OA\Property(
        description: 'E-mail do usuário',
        type: 'string',
        format: 'email',
        example: 'joao@email.com'
    )]
    public string $email;

    #[OA\Property(
        description: 'Senha do usuário. Deve possuir no mínimo 8 caracteres, incluindo ao menos uma letra maiúscula, um número e um caractere especial.',
        type: 'string',
        format: 'password',
        minLength: 8,
        example: 'Senha@123'
    )]
    public string $password;

    #[OA\Property(
        description: 'Confirmação da senha. Deve ser igual ao campo password.',
        type: 'string',
        format: 'password',
        minLength: 8,
        example: 'Senha@123'
    )]
    public string $confirm_password;
}

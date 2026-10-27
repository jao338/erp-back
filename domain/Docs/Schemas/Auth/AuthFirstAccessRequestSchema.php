<?php

namespace ERP\Docs\Schemas\Auth;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'AuthFirstAccessRequestSchema',
    required: ['email']
)]
class AuthFirstAccessRequestSchema
{
    #[OA\Property(
        description: 'E-mail do usuário que realizará o primeiro acesso',
        type: 'string',
        format: 'email',
        example: 'joao@email.com'
    )]
    public string $email;
}

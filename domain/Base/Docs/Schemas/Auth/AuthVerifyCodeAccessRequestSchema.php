<?php

namespace Base\Base\Docs\Schemas\Auth;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'AuthVerifyCodeAccessRequestSchema',
    required: ['email', 'code']
)]
class AuthVerifyCodeAccessRequestSchema
{
    #[OA\Property(
        description: 'E-mail do usuário que realizará o primeiro acesso',
        type: 'string',
        format: 'email',
        example: 'joao@email.com'
    )]
    public string $email;

    #[OA\Property(
        description: 'Código de confirmação recebido por e-mail',
        type: 'integer',
        minimum: 10000,
        maximum: 99999,
        example: 12345
    )]
    public int $code;
}

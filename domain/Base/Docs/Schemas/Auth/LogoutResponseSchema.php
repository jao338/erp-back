<?php

namespace Base\Base\Docs\Schemas\Auth;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'LogoutResponseSchema',
    required: ['message']
)]
class LogoutResponseSchema
{
    #[OA\Property(
        description: 'Mensagem informando que o logout foi realizado com sucesso.',
        example: 'Logout realizado com sucesso.'
    )]
    public string $message;
}

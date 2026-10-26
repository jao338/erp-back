<?php

namespace Base\Base\Docs\Schemas\Auth;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'AuthMessageResponseSchema',
    required: ['message']
)]
class AuthMessageResponseSchema
{
    #[OA\Property(
        description: 'Mensagem informativa da operação',
        example: 'Operação realizada com sucesso.'
    )]
    public string $message;
}

<?php

namespace Base\Base\Docs\Schemas\Errors;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'UnauthorizedResponseSchema'
)]
class UnauthorizedResponseSchema
{
    #[OA\Property(
        description: 'Não autorizado',
        example: 'Credenciais inválidas.'
    )]
    public string $message;
}
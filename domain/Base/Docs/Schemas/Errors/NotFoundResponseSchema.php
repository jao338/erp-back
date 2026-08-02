<?php

namespace Base\Base\Docs\Schemas\Errors;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'NotFoundResponseSchema'
)]
class NotFoundResponseSchema
{
    #[OA\Property(
        example: 'Registro não encontrado.'
    )]
    public string $message;
}
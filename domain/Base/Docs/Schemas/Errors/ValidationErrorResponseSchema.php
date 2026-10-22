<?php

namespace Base\Base\Docs\Schemas\Errors;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ValidationErrorResponse'
)]
class ValidationErrorResponseSchema
{
    #[OA\Property(
        example: 'O valor do campo passado é inválido'
    )]
    public string $message;

    #[OA\Property(
        type: 'object',
        additionalProperties: new OA\AdditionalProperties(
            type: 'array',
            items: new OA\Items(
                type: 'string'
            )
        ),
        example: [
            'email' => [
                'O campo email é obrigatório.'
            ],
            'password' => [
                'A senha deve possuir no mínimo 8 caracteres.'
            ]
        ]
    )]
    public object $errors;
}
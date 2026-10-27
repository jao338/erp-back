<?php

namespace ERP\Docs\Schemas\Errors;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ERPErrorResponse',
    required: ['status', 'message']
)]
class ERPErrorResponseSchema
{
    #[OA\Property(
        description: 'Status da operação',
        example: 'error'
    )]
    public string $status;

    #[OA\Property(
        description: 'Mensagem explicando o erro',
        example: 'Código inválido ou expirado.'
    )]
    public string $message;
}

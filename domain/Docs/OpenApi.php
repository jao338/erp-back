<?php

namespace ERP\Docs;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'ERP API',
    version: '1.0.0',
    description: 'API do ERP'
)]
#[OA\Server(
    url: L5_SWAGGER_CONST_HOST,
    description: 'Servidor da API'
)]
#[OA\SecurityScheme(
    securityScheme: 'sanctum',
    type: 'http',
    scheme: 'bearer',
    bearerFormat: 'Sanctum token',
    description: 'Token Sanctum enviado no cabeçalho Authorization.'
)]

#[OA\Tag(
    name: 'Autenticação',
    description: 'Endpoints relacionados à autenticação.'
)]

#[OA\Tag(
    name: 'Usuários',
    description: 'Endpoints relacionados aos usuários.'
)]

#[OA\Tag(
    name: 'Produtos',
    description: 'Endpoints relacionados aos produtos.'
)]
class OpenApi
{
}

<?php

namespace Base\Base\Docs;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'ERP API',
    version: '1.0.0',
    description: 'API do ERP'
)]
#[OA\Server(
    url: L5_SWAGGER_CONST_HOST
)]
class OpenApi
{
}
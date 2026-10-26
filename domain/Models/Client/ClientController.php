<?php

namespace Base\Models\Client;

use App\Http\Controllers\Controller;
use Base\Models\Client\Actions\IndexAction;
use Base\Models\Client\Actions\ShowAction;
use Base\Models\Client\Actions\LookupAction;
use Base\Models\Client\Requests\ClientFilterRequest;
use Base\Models\Client\Resources\ClientResource;
use Base\Base\Docs\Schemas\Client\ClientCollectionResponseSchema;
use Base\Base\Docs\Schemas\Client\ClientLookupResponseSchema;
use Base\Base\Docs\Schemas\Client\ClientResponseSchema;
use Base\Base\Docs\Schemas\Errors\NotFoundResponseSchema;
use Base\Base\Docs\Schemas\Errors\UnauthorizedResponseSchema;
use Base\Base\Docs\Schemas\Errors\ValidationErrorResponseSchema;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ClientController extends Controller {

    #[OA\Get(
        path: '/api/clients',
        summary: 'Lista clientes',
        tags: ['Clientes'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'nome', in: 'query', description: 'Filtra pelo nome do cliente', required: false, schema: new OA\Schema(type: 'string', maxLength: 255)),
            new OA\Parameter(name: 'cpf', in: 'query', description: 'Filtra pelo CPF do cliente', required: false, schema: new OA\Schema(type: 'string', maxLength: 11)),
            new OA\Parameter(name: 'email', in: 'query', description: 'Filtra pelo e-mail do cliente', required: false, schema: new OA\Schema(type: 'string', format: 'email')),
            new OA\Parameter(name: 'telefone', in: 'query', description: 'Filtra pelo telefone do cliente', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'campo_ordenacao', in: 'query', description: 'Campo usado na ordenação', required: false, schema: new OA\Schema(type: 'string', example: 'created_at')),
            new OA\Parameter(name: 'tipo_ordenacao', in: 'query', description: 'Direção da ordenação', required: false, schema: new OA\Schema(type: 'string', enum: ['ASC', 'DESC'], example: 'DESC')),
            new OA\Parameter(name: 'por_pagina', in: 'query', description: 'Quantidade de itens por página; padrão 20', required: false, schema: new OA\Schema(type: 'integer', minimum: 1, default: 20)),
            new OA\Parameter(name: 'page', in: 'query', description: 'Número da página', required: false, schema: new OA\Schema(type: 'integer', minimum: 1, default: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Clientes listados com paginação', content: new OA\JsonContent(ref: ClientCollectionResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 422, description: 'Erro de validação dos filtros', content: new OA\JsonContent(ref: ValidationErrorResponseSchema::class)),
        ]
    )]
    public function index(ClientFilterRequest $request, IndexAction $action): JsonResource
    {
        return ClientResource::collection($action->handle($request->all()));
    }

    #[OA\Get(
        path: '/api/clients/{uuid}',
        summary: 'Retorna um cliente',
        tags: ['Clientes'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'uuid', in: 'path', description: 'UUID do cliente', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Cliente retornado com sucesso', content: new OA\JsonContent(ref: ClientResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 404, description: 'Cliente não encontrado', content: new OA\JsonContent(ref: NotFoundResponseSchema::class)),
        ]
    )]
    public function show(string $uuid, ShowAction $action): JsonResource
    {
        return new ClientResource($action->handle($uuid));
    }

    #[OA\Get(
        path: '/api/lookups/clients',
        summary: 'Lista clientes para seleção',
        tags: ['Clientes'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Clientes disponíveis para lookup', content: new OA\JsonContent(ref: ClientLookupResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
        ]
    )]
    public function lookup(LookupAction $action): JsonResponse
    {
        return response()->json(['data' => ($action->handle())]);
    }
}

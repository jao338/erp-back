<?php

namespace Base\Models\Shopping;

use App\Http\Controllers\Controller;
use Base\Models\Shopping\Actions\CancelAction;
use Base\Models\Shopping\Actions\CreateAction;
use Base\Models\Shopping\Actions\IndexAction;
use Base\Models\Shopping\Actions\ShowAction;
use Base\Models\Shopping\Requests\ShoppingFilterRequest;
use Base\Models\Shopping\Requests\ShoppingRequest;
use Base\Models\Shopping\Resources\ShoppingResource;
use Base\Base\Docs\Schemas\Errors\NotFoundResponseSchema;
use Base\Base\Docs\Schemas\Errors\UnauthorizedResponseSchema;
use Base\Base\Docs\Schemas\Errors\ValidationErrorResponseSchema;
use Base\Base\Docs\Schemas\Shopping\ShoppingCollectionResponseSchema;
use Base\Base\Docs\Schemas\Shopping\ShoppingRequestSchema;
use Base\Base\Docs\Schemas\Shopping\ShoppingShowResponseSchema;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class ShoppingController extends Controller {

    #[OA\Get(
        path: '/api/shopping',
        summary: 'Lista compras',
        tags: ['Compras'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'total', in: 'query', description: 'Filtra pelo total da compra', required: false, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'criado_em', in: 'query', description: 'Filtra pela data de criação', required: false, schema: new OA\Schema(type: 'string', format: 'date-time')),
            new OA\Parameter(name: 'atualizado_em', in: 'query', description: 'Filtra pela data de atualização', required: false, schema: new OA\Schema(type: 'string', format: 'date-time')),
            new OA\Parameter(name: 'campo_ordenacao', in: 'query', description: 'Campo usado na ordenação', required: false, schema: new OA\Schema(type: 'string', example: 'created_at')),
            new OA\Parameter(name: 'tipo_ordenacao', in: 'query', description: 'Direção da ordenação', required: false, schema: new OA\Schema(type: 'string', enum: ['ASC', 'DESC'], example: 'DESC')),
            new OA\Parameter(name: 'por_pagina', in: 'query', description: 'Quantidade de itens por página; padrão 20', required: false, schema: new OA\Schema(type: 'integer', minimum: 1, default: 20)),
            new OA\Parameter(name: 'page', in: 'query', description: 'Número da página', required: false, schema: new OA\Schema(type: 'integer', minimum: 1, default: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Compras listadas com paginação', content: new OA\JsonContent(ref: ShoppingCollectionResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 422, description: 'Erro de validação dos filtros', content: new OA\JsonContent(ref: ValidationErrorResponseSchema::class)),
        ]
    )]
    public function index(ShoppingFilterRequest $request, IndexAction $action): JsonResource
    {
        return ShoppingResource::collection($action->handle($request->all()));
    }

    #[OA\Get(
        path: '/api/shopping/{uuid}',
        summary: 'Retorna uma compra',
        tags: ['Compras'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'uuid', in: 'path', description: 'UUID da compra', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Compra retornada com sucesso', content: new OA\JsonContent(ref: ShoppingShowResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 404, description: 'Compra não encontrada', content: new OA\JsonContent(ref: NotFoundResponseSchema::class)),
        ]
    )]
    public function show(string $uuid, ShowAction $action): JsonResource
    {
        return new ShoppingResource($action->handle($uuid));
    }

    #[OA\Post(
        path: '/api/shopping',
        summary: 'Registra uma compra',
        tags: ['Compras'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: ShoppingRequestSchema::class)
        ),
        responses: [
            new OA\Response(response: 200, description: 'Compra registrada com sucesso', content: new OA\JsonContent(ref: ShoppingShowResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 422, description: 'Dados da compra inválidos', content: new OA\JsonContent(ref: ValidationErrorResponseSchema::class)),
        ]
    )]
    public function store(ShoppingRequest $request, CreateAction $action): JsonResource
    {
        return new ShoppingResource($action->handle($request->validated()));
    }

    #[OA\Delete(
        path: '/api/shopping/{uuid}',
        summary: 'Cancela uma compra',
        tags: ['Compras'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'uuid', in: 'path', description: 'UUID da compra', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        responses: [
            new OA\Response(response: 204, description: 'Compra cancelada com sucesso'),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 404, description: 'Compra não encontrada', content: new OA\JsonContent(ref: NotFoundResponseSchema::class)),
        ]
    )]
    public function destroy(string $uuid, CancelAction $action): Response
    {
        $action->handle($uuid);

        return response()->noContent();
    }
}

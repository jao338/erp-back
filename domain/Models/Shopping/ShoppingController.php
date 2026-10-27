<?php

namespace ERP\Models\Shopping;

use App\Http\Controllers\Controller;
use ERP\Models\Shopping\Actions\CancelAction;
use ERP\Models\Shopping\Actions\CreateAction;
use ERP\Models\Shopping\Actions\IndexAction;
use ERP\Models\Shopping\Actions\ShowAction;
use ERP\Models\Shopping\Requests\ShoppingFilterRequest;
use ERP\Models\Shopping\Requests\ShoppingRequest;
use ERP\Models\Shopping\Resources\ShoppingResource;
use ERP\Docs\Schemas\Errors\NotFoundResponseSchema;
use ERP\Docs\Schemas\Errors\UnauthorizedResponseSchema;
use ERP\Docs\Schemas\Errors\ValidationErrorResponseSchema;
use ERP\Docs\Schemas\Shopping\ShoppingCollectionResponseSchema;
use ERP\Docs\Schemas\Shopping\ShoppingRequestSchema;
use ERP\Docs\Schemas\Shopping\ShoppingShowResponseSchema;
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

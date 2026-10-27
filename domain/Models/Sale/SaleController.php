<?php

namespace ERP\Models\Sale;

use App\Http\Controllers\Controller;
use ERP\Models\Sale\Actions\CancelAction;
use ERP\Models\Sale\Actions\CreateAction;
use ERP\Models\Sale\Actions\IndexAction;
use ERP\Models\Sale\Actions\ShowAction;
use ERP\Models\Sale\Requests\SaleFilterRequest;
use ERP\Models\Sale\Requests\SaleRequest;
use ERP\Models\Sale\Resources\SaleResource;
use ERP\Docs\Schemas\Errors\ERPErrorResponseSchema;
use ERP\Docs\Schemas\Errors\NotFoundResponseSchema;
use ERP\Docs\Schemas\Errors\UnauthorizedResponseSchema;
use ERP\Docs\Schemas\Errors\ValidationErrorResponseSchema;
use ERP\Docs\Schemas\Sale\SaleCollectionResponseSchema;
use ERP\Docs\Schemas\Sale\SaleRequestSchema;
use ERP\Docs\Schemas\Sale\SaleShowResponseSchema;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class SaleController extends Controller {

    #[OA\Get(
        path: '/api/sale',
        summary: 'Lista vendas',
        tags: ['Vendas'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'total', in: 'query', description: 'Filtra pelo total da venda', required: false, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'criado_em', in: 'query', description: 'Filtra pela data de criação', required: false, schema: new OA\Schema(type: 'string', format: 'date')),
            new OA\Parameter(name: 'atualizado_em', in: 'query', description: 'Filtra pela data de atualização', required: false, schema: new OA\Schema(type: 'string', format: 'date')),
            new OA\Parameter(name: 'ativo', in: 'query', description: 'Filtra pelo estado ativo da venda', required: false, schema: new OA\Schema(type: 'boolean')),
            new OA\Parameter(name: 'lucro', in: 'query', description: 'Filtra pelo lucro da venda', required: false, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'campo_ordenacao', in: 'query', description: 'Campo usado na ordenação', required: false, schema: new OA\Schema(type: 'string', example: 'created_at')),
            new OA\Parameter(name: 'tipo_ordenacao', in: 'query', description: 'Direção da ordenação', required: false, schema: new OA\Schema(type: 'string', enum: ['ASC', 'DESC'], example: 'DESC')),
            new OA\Parameter(name: 'por_pagina', in: 'query', description: 'Quantidade de itens por página; padrão 20', required: false, schema: new OA\Schema(type: 'integer', minimum: 1, default: 20)),
            new OA\Parameter(name: 'page', in: 'query', description: 'Número da página', required: false, schema: new OA\Schema(type: 'integer', minimum: 1, default: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Vendas listadas com paginação', content: new OA\JsonContent(ref: SaleCollectionResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 422, description: 'Erro de validação dos filtros', content: new OA\JsonContent(ref: ValidationErrorResponseSchema::class)),
        ]
    )]
    public function index(SaleFilterRequest $request, IndexAction $action): JsonResource
    {
        return SaleResource::collection($action->handle($request->all()));
    }

    #[OA\Get(
        path: '/api/sale/{uuid}',
        summary: 'Retorna uma venda',
        tags: ['Vendas'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'uuid', in: 'path', description: 'UUID da venda', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Venda retornada com sucesso', content: new OA\JsonContent(ref: SaleShowResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 404, description: 'Venda não encontrada', content: new OA\JsonContent(ref: NotFoundResponseSchema::class)),
        ]
    )]
    public function show(string $uuid, ShowAction $action): JsonResource
    {
        return new SaleResource($action->handle($uuid));
    }

    #[OA\Post(
        path: '/api/sale',
        summary: 'Registra uma venda',
        tags: ['Vendas'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: SaleRequestSchema::class)
        ),
        responses: [
            new OA\Response(response: 200, description: 'Venda registrada com sucesso', content: new OA\JsonContent(ref: SaleShowResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(
                response: 422,
                description: 'Dados inválidos ou estoque insuficiente',
                content: new OA\JsonContent(
                    oneOf: [
                        new OA\Schema(ref: ValidationErrorResponseSchema::class),
                        new OA\Schema(ref: ERPErrorResponseSchema::class),
                    ]
                )
            ),
        ]
    )]
    public function store(SaleRequest $request, CreateAction $action): JsonResource
    {
        return new SaleResource($action->handle($request->validated()));
    }

    #[OA\Delete(
        path: '/api/sale/{uuid}',
        summary: 'Cancela uma venda',
        tags: ['Vendas'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'uuid', in: 'path', description: 'UUID da venda', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        responses: [
            new OA\Response(response: 204, description: 'Venda cancelada com sucesso'),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 404, description: 'Venda não encontrada', content: new OA\JsonContent(ref: NotFoundResponseSchema::class)),
        ]
    )]
    public function destroy(string $uuid, CancelAction $action): Response
    {
        $action->handle($uuid);

        return response()->noContent();
    }
}

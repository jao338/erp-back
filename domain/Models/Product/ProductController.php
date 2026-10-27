<?php

namespace ERP\Models\Product;

use App\Http\Controllers\Controller;
use ERP\Models\Product\Actions\CreateAction;
use ERP\Models\Product\Actions\DestroyAction;
use ERP\Models\Product\Actions\IndexAction;
use ERP\Models\Product\Actions\ShowAction;
use ERP\Models\Product\Actions\UpdateAction;
use ERP\Models\Product\Requests\ProductFilterRequest;
use ERP\Models\Product\Requests\ProductRequest;
use ERP\Models\Product\Resources\ProductResource;
use ERP\Docs\Schemas\Errors\NotFoundResponseSchema;
use ERP\Docs\Schemas\Errors\UnauthorizedResponseSchema;
use ERP\Docs\Schemas\Errors\ValidationErrorResponseSchema;
use ERP\Docs\Schemas\Product\ProductCollectionResponseSchema;
use ERP\Docs\Schemas\Product\ProductRequestSchema;
use ERP\Docs\Schemas\Product\ProductShowResponseSchema;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

class ProductController extends Controller {

    #[OA\Get(
        path: '/api/products',
        summary: 'Lista produtos',
        tags: ['Produtos'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'nome', in: 'query', description: 'Filtra pelo nome do produto', required: false, schema: new OA\Schema(type: 'string', maxLength: 255)),
            new OA\Parameter(name: 'custo_medio', in: 'query', description: 'Filtra pelo custo médio', required: false, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'preco_venda', in: 'query', description: 'Filtra pelo preço de venda', required: false, schema: new OA\Schema(type: 'number', format: 'float')),
            new OA\Parameter(name: 'quantidade', in: 'query', description: 'Filtra pela quantidade', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'criado_em', in: 'query', description: 'Filtra pela data de criação', required: false, schema: new OA\Schema(type: 'string', format: 'date')),
            new OA\Parameter(name: 'atualizado_em', in: 'query', description: 'Filtra pela data de atualização', required: false, schema: new OA\Schema(type: 'string', format: 'date')),
            new OA\Parameter(name: 'campo_ordenacao', in: 'query', description: 'Campo usado na ordenação', required: false, schema: new OA\Schema(type: 'string', example: 'created_at')),
            new OA\Parameter(name: 'tipo_ordenacao', in: 'query', description: 'Direção da ordenação', required: false, schema: new OA\Schema(type: 'string', enum: ['ASC', 'DESC'], example: 'DESC')),
            new OA\Parameter(name: 'por_pagina', in: 'query', description: 'Quantidade de itens por página; padrão 20', required: false, schema: new OA\Schema(type: 'integer', minimum: 1, default: 20)),
            new OA\Parameter(name: 'page', in: 'query', description: 'Número da página', required: false, schema: new OA\Schema(type: 'integer', minimum: 1, default: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Produtos listados com paginação', content: new OA\JsonContent(ref: ProductCollectionResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 422, description: 'Erro de validação dos filtros', content: new OA\JsonContent(ref: ValidationErrorResponseSchema::class)),
        ]
    )]
    public function index(ProductFilterRequest $request, IndexAction $action): JsonResource
    {
        return ProductResource::collection($action->handle($request->all()));
    }

    #[OA\Get(
        path: '/api/products/{uuid}',
        summary: 'Retorna um produto',
        tags: ['Produtos'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'uuid', in: 'path', description: 'UUID do produto', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Produto retornado com sucesso', content: new OA\JsonContent(ref: ProductShowResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 404, description: 'Produto não encontrado', content: new OA\JsonContent(ref: NotFoundResponseSchema::class)),
        ]
    )]
    public function show(string $uuid, ShowAction $action): JsonResource
    {
        return new ProductResource($action->handle($uuid));
    }

    #[OA\Post(
        path: '/api/products',
        summary: 'Cria um produto',
        tags: ['Produtos'],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: ProductRequestSchema::class)),
        responses: [
            new OA\Response(response: 200, description: 'Produto criado com sucesso', content: new OA\JsonContent(ref: ProductShowResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 422, description: 'Erro de validação', content: new OA\JsonContent(ref: ValidationErrorResponseSchema::class)),
        ]
    )]
    public function store(ProductRequest $request, CreateAction $action): JsonResource
    {
        return new ProductResource($action->handle($request->validated()));
    }

    #[OA\Put(
        path: '/api/products/{uuid}',
        summary: 'Atualiza um produto',
        tags: ['Produtos'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'uuid', in: 'path', description: 'UUID do produto', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: ProductRequestSchema::class)),
        responses: [
            new OA\Response(response: 204, description: ''),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 404, description: 'Produto não encontrado', content: new OA\JsonContent(ref: NotFoundResponseSchema::class)),
            new OA\Response(response: 422, description: 'Erro de validação', content: new OA\JsonContent(ref: ValidationErrorResponseSchema::class)),
        ]
    )]
    public function update(string $uuid, ProductRequest $request, UpdateAction $action): Response
    {
        $action->handle($uuid, $request->validated());

        return response()->noContent();
    }

    #[OA\Delete(
        path: '/api/products/{uuid}',
        summary: 'Exclui um produto',
        tags: ['Produtos'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'uuid', in: 'path', description: 'UUID do produto', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        responses: [
            new OA\Response(response: 204, description: ''),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 404, description: 'Produto não encontrado', content: new OA\JsonContent(ref: NotFoundResponseSchema::class)),
        ]
    )]
    public function destroy(string $uuid, DestroyAction $action): Response
    {
        $action->handle($uuid);

        return response()->noContent();
    }
}

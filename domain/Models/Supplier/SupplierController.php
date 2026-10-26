<?php

namespace Base\Models\Supplier;

use App\Http\Controllers\Controller;
use Base\Models\Supplier\Actions\IndexAction;
use Base\Models\Supplier\Actions\ShowAction;
use Base\Models\Supplier\Actions\LookupAction;
use Base\Models\Supplier\Requests\SupplierFilterRequest;
use Base\Models\Supplier\Resources\SupplierResource;
use Base\Base\Docs\Schemas\Errors\NotFoundResponseSchema;
use Base\Base\Docs\Schemas\Errors\UnauthorizedResponseSchema;
use Base\Base\Docs\Schemas\Errors\ValidationErrorResponseSchema;
use Base\Base\Docs\Schemas\Supplier\SupplierCollectionResponseSchema;
use Base\Base\Docs\Schemas\Supplier\SupplierLookupResponseSchema;
use Base\Base\Docs\Schemas\Supplier\SupplierShowResponseSchema;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

class SupplierController extends Controller {

    #[OA\Get(
        path: '/api/suppliers',
        summary: 'Lista fornecedores',
        tags: ['Fornecedores'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'nome', in: 'query', description: 'Filtra pelo nome do fornecedor', required: false, schema: new OA\Schema(type: 'string', maxLength: 255)),
            new OA\Parameter(name: 'cnpj', in: 'query', description: 'Filtra pelo CNPJ do fornecedor', required: false, schema: new OA\Schema(type: 'string', maxLength: 14)),
            new OA\Parameter(name: 'email', in: 'query', description: 'Filtra pelo e-mail do fornecedor', required: false, schema: new OA\Schema(type: 'string', format: 'email')),
            new OA\Parameter(name: 'telephone', in: 'query', description: 'Filtra pelo telefone do fornecedor', required: false, schema: new OA\Schema(type: 'integer')),
            new OA\Parameter(name: 'campo_ordenacao', in: 'query', description: 'Campo usado na ordenação', required: false, schema: new OA\Schema(type: 'string', example: 'created_at')),
            new OA\Parameter(name: 'tipo_ordenacao', in: 'query', description: 'Direção da ordenação', required: false, schema: new OA\Schema(type: 'string', enum: ['ASC', 'DESC'], example: 'DESC')),
            new OA\Parameter(name: 'por_pagina', in: 'query', description: 'Quantidade de itens por página; padrão 20', required: false, schema: new OA\Schema(type: 'integer', minimum: 1, default: 20)),
            new OA\Parameter(name: 'page', in: 'query', description: 'Número da página', required: false, schema: new OA\Schema(type: 'integer', minimum: 1, default: 1)),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Fornecedores listados com paginação', content: new OA\JsonContent(ref: SupplierCollectionResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 422, description: 'Erro de validação dos filtros', content: new OA\JsonContent(ref: ValidationErrorResponseSchema::class)),
        ]
    )]
    public function index(SupplierFilterRequest $request, IndexAction $action): JsonResource
    {
        return SupplierResource::collection($action->handle($request->all()));
    }

    #[OA\Get(
        path: '/api/suppliers/{uuid}',
        summary: 'Retorna um fornecedor',
        tags: ['Fornecedores'],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'uuid', in: 'path', description: 'UUID do fornecedor', required: true, schema: new OA\Schema(type: 'string', format: 'uuid')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Fornecedor retornado com sucesso', content: new OA\JsonContent(ref: SupplierShowResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
            new OA\Response(response: 404, description: 'Fornecedor não encontrado', content: new OA\JsonContent(ref: NotFoundResponseSchema::class)),
        ]
    )]
    public function show(string $uuid, ShowAction $action): JsonResource
    {
        return new SupplierResource($action->handle($uuid));
    }

    #[OA\Get(
        path: '/api/lookups/suppliers',
        summary: 'Lista fornecedores para seleção',
        tags: ['Fornecedores'],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Fornecedores disponíveis para lookup', content: new OA\JsonContent(ref: SupplierLookupResponseSchema::class)),
            new OA\Response(response: 401, description: 'Usuário não autenticado', content: new OA\JsonContent(ref: UnauthorizedResponseSchema::class)),
        ]
    )]
    public function lookup(LookupAction $action): JsonResponse
    {
        return response()->json(['data' => ($action->handle())]);
    }
}

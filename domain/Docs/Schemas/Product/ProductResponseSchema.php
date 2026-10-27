<?php

namespace ERP\Docs\Schemas\Product;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ProductResponse',
    required: ['nome', 'custo_medio', 'preco_venda', 'quantidade', 'criado_em', 'atualizado_em', 'uuid']
)]
class ProductResponseSchema
{
    #[OA\Property(description: 'Nome do produto', example: 'Café especial')]
    public string $nome;

    #[OA\Property(description: 'Custo médio do produto', example: 12.5)]
    public float $custo_medio;

    #[OA\Property(description: 'Preço de venda do produto', example: 18.9)]
    public float $preco_venda;

    #[OA\Property(description: 'Quantidade disponível', example: 100)]
    public int $quantidade;

    #[OA\Property(description: 'Data de criação do produto', format: 'date-time', example: '2026-01-15T10:30:00Z')]
    public string $criado_em;

    #[OA\Property(description: 'Data da última atualização do produto', format: 'date-time', example: '2026-01-15T10:30:00Z')]
    public string $atualizado_em;

    #[OA\Property(
        description: 'Identificador único do produto',
        format: 'uuid',
        example: '550e8400-e29b-41d4-a716-446655440000'
    )]
    public string $uuid;
}

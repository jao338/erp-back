<?php

namespace Base\Base\Docs\Schemas\Product;

use OpenApi\Attributes as OA;

#[OA\Schema(schema: 'ProductFilter')]
class ProductFilterSchema
{
    #[OA\Property(description: 'Filtra pelo nome do produto', maxLength: 255, example: 'Café')]
    public ?string $nome;

    #[OA\Property(description: 'Filtra pelo custo médio', example: 12.5)]
    public ?float $custo_medio;

    #[OA\Property(description: 'Filtra pelo preço de venda', example: 18.9)]
    public ?float $preco_venda;

    #[OA\Property(description: 'Filtra pela quantidade', example: 100)]
    public ?int $quantidade;

    #[OA\Property(description: 'Filtra pela data de criação', format: 'date', example: '2026-01-15')]
    public ?string $criado_em;

    #[OA\Property(description: 'Filtra pela data de atualização', format: 'date', example: '2026-01-15')]
    public ?string $atualizado_em;
}

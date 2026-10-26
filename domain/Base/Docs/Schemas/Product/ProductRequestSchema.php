<?php

namespace Base\Base\Docs\Schemas\Product;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ProductRequest',
    required: ['nome', 'custo_medio', 'preco_venda']
)]
class ProductRequestSchema
{
    #[OA\Property(description: 'Nome do produto', minLength: 3, maxLength: 50, example: 'Café especial')]
    public string $nome;

    #[OA\Property(description: 'Custo médio do produto, com duas casas decimais', minimum: 0.01, example: 12.5)]
    public float $custo_medio;

    #[OA\Property(description: 'Preço de venda do produto, com duas casas decimais', minimum: 0.01, example: 18.9)]
    public float $preco_venda;

    #[OA\Property(description: 'Quantidade do produto; quando omitida na criação, assume zero', nullable: true, example: 100)]
    public ?int $quantidade;
}

<?php

namespace ERP\Models\Product\Actions;

use ERP\Models\Product\Product;

final readonly class CreateAction
{

    public function __construct(protected Product $model) { }

    public function handle(array $data): Product
    {
        return $this->model->create([
            "name"         => $data["nome"],
            "average_cost" => $data["custo_medio"],
            "sale_price"   => $data["preco_venda"],
            "amount"       => $data["quantidade"] ?? 0,
        ]);
    }
}

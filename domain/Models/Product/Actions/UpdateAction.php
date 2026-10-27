<?php

namespace ERP\Models\Product\Actions;

use ERP\Models\Product\Product;

final readonly class UpdateAction
{

    public function __construct(protected Product $model) {}

    public function handle(string $uuid, array $data): bool
    {
        $product = $this->model->where('uuid', $uuid)->firstOrFail();

        return $product->update([
            "name"          => $data["nome"],
            "average_cost"  => $data["custo_medio"],
            "sale_price"    => $data["preco_venda"],
            "amount"        => $data["quantidade"],
        ]);

    }
}

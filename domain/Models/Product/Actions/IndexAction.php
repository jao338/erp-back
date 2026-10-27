<?php

namespace ERP\Models\Product\Actions;

use ERP\Models\Product\Product;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class IndexAction {

    public function __construct(protected Product $model) {}

    public function handle(array $data): LengthAwarePaginator
    {

        $name               = $data['nome'] ?? null;
        $average_cost       = $data['custo_medio'] ?? null;
        $sale_price         = $data['preco_venda'] ?? null;
        $amount             = $data['quantidade'] ?? null;
        $created_at         = $data['criado_em'] ?? null;
        $updated_at         = $data['atualizado_em'] ?? null;

        $tipo_ordenacao     = $data['tipo_ordenacao'] ?? null;
        $campo_ordenacao    = $data['campo_ordenacao'] ?? null;
        $por_pagina         = $data['por_pagina'] ?? 20;

        return $this->model
            ->when(isset($name), fn($query)         => $query->where('name', 'LIKE', "%$name%"))
            ->when(isset($average_cost), fn($query) => $query->where('average_cost', $average_cost))
            ->when(isset($sale_price), fn($query)   => $query->where('sale_price', $sale_price))
            ->when(isset($amount), fn($query)       => $query->where('amount', $amount))
            ->when(isset($created_at), fn($query)   => $query->where('created_at', 'LIKE', "%$created_at%"))
            ->when(isset($updated_at), fn($query)   => $query->where('updated_at', 'LIKE', "%$updated_at%"))
            ->when(
                !isset($campo_ordenacao) && !isset($tipo_ordenacao),
                fn($query) => $query->orderBy('created_at', 'DESC'),
                fn($query) => $query->orderBy($campo_ordenacao, $tipo_ordenacao)
            )
            ->paginate($por_pagina);
    }
}

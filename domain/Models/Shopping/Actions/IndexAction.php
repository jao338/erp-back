<?php

namespace ERP\Models\Shopping\Actions;

use ERP\Models\Shopping\Shopping;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class IndexAction {

    public function __construct(protected Shopping $model) {}

    public function handle(array $data): LengthAwarePaginator
    {
        $total               = $data['total'] ?? null;
        $created_at          = $data['criado_em'] ?? null;
        $updated_at          = $data['atualizado_em'] ?? null;

        $tipo_ordenacao     = $data['tipo_ordenacao'] ?? null;
        $campo_ordenacao    = $data['campo_ordenacao'] ?? null;
        $por_pagina         = $data['por_pagina'] ?? 20;

        return $this->model
            ->with(['shoppingItems', 'supplier'])
            ->when(isset($total), fn($query)        => $query->where('total', 'LIKE', "%$total%"))
            ->when(isset($created_at), fn($query)   => $query->where('created_at', $created_at))
            ->when(isset($updated_at), fn($query)   => $query->where('updated_at', $updated_at))
            ->when(
                !isset($campo_ordenacao) && !isset($tipo_ordenacao),
                fn($query) => $query->orderBy('created_at', 'DESC'),
                fn($query) => $query->orderBy($campo_ordenacao, $tipo_ordenacao)
            )
            ->paginate($por_pagina);
    }
}

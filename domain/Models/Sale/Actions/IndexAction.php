<?php

namespace ERP\Models\Sale\Actions;

use ERP\Models\Sale\Sale;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class IndexAction {

    public function __construct(protected Sale $model) {}

    public function handle(array $data): LengthAwarePaginator
    {
        $total               = $data['total'] ?? null;
        $created_at          = $data['criado_em'] ?? null;
        $updated_at          = $data['atualizado_em'] ?? null;
        $active              = $data['ativo'] ?? null;
        $profit              = $data['lucro'] ?? null;

        $tipo_ordenacao     = $data['tipo_ordenacao'] ?? null;
        $campo_ordenacao    = $data['campo_ordenacao'] ?? null;
        $por_pagina         = $data['por_pagina'] ?? 20;

        return $this->model
            ->with(['saleItems', 'client'])
            ->when(isset($total), fn($query)        => $query->where('total', 'LIKE', "%$total%"))
            ->when(isset($created_at), fn($query)   => $query->where('created_at', $created_at))
            ->when(isset($updated_at), fn($query)   => $query->where('updated_at', $updated_at))
            ->when(isset($active), fn($query)       => $query->where('active', $active))
            ->when(isset($profit), fn($query)       => $query->where('profit', $profit))
            ->when(
                !isset($campo_ordenacao) && !isset($tipo_ordenacao),
                fn($query) => $query->orderBy('created_at', 'DESC'),
                fn($query) => $query->orderBy($campo_ordenacao, $tipo_ordenacao)
            )
            ->paginate($por_pagina);
    }
}

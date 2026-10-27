<?php

namespace ERP\Models\Supplier\Actions;

use ERP\Models\Supplier\Supplier;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class IndexAction {

    public function __construct(protected Supplier $model) {}

    public function handle(array $data): LengthAwarePaginator
    {

        $name               = $data['nome'] ?? null;
        $cnpj               = $data['cnpj'] ?? null;
        $email              = $data['email'] ?? null;
        $telephone          = $data['telephone'] ?? null;

        $tipo_ordenacao     = $data['tipo_ordenacao'] ?? null;
        $campo_ordenacao    = $data['campo_ordenacao'] ?? null;
        $por_pagina         = $data['por_pagina'] ?? 20;

        return $this->model
            ->when(isset($name), fn($query)         => $query->where('name', 'LIKE', "%$name%"))
            ->when(isset($cnpj), fn($query)         => $query->where('cnpj', 'LIKE', "%$cnpj%"))
            ->when(isset($email), fn($query)        => $query->where('email', 'LIKE', "%$email%"))
            ->when(isset($telephone), fn($query)    => $query->where('telephone', 'LIKE', "%$telephone%"))
            ->when(
                !isset($campo_ordenacao) && !isset($tipo_ordenacao),
                fn($query) => $query->orderBy('created_at', 'DESC'),
                fn($query) => $query->orderBy($campo_ordenacao, $tipo_ordenacao)
            )
            ->paginate($por_pagina);
    }
}

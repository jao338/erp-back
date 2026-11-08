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
        $cpf                = $data['cpf'] ?? null;
        $email              = $data['email'] ?? null;
        $telephone          = $data['telefone'] ?? null;

        $tipo_ordenacao     = $data['tipo_ordenacao'] ?? 'DESC';
        $campo_ordenacao    = $data['campo_ordenacao'] ?? 'created_at';
        $por_pagina         = $data['por_pagina'] ?? 20;

        return $this->model
            ->with(['person'])
            ->when(isset($name), fn($query)         => $query->whereRelation('person', 'name', 'LIKE', "%$name%"))
            ->when(isset($cnpj), fn($query)         => $query->whereRelation('person', 'cnpj', 'LIKE', "%$cnpj%"))
            ->when(isset($cpf), fn($query)          => $query->whereRelation('person', 'cpf', 'LIKE', "%$cpf%"))
            ->when(isset($email), fn($query)        => $query->whereRelation('person', 'email', 'LIKE', "%$email%"))
            ->when(isset($telephone), fn($query)    => $query->whereRelation('person', 'telephone', 'LIKE', "%$telephone%"))
            ->orderBy($campo_ordenacao, $tipo_ordenacao)
            ->paginate($por_pagina);
    }
}

<?php

namespace ERP\Models\Client\Actions;

use ERP\Models\Client\Client;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class IndexAction {

    public function __construct(protected Client $model) {}

    public function handle(array $data): LengthAwarePaginator
    {
        $name               = $data['nome'] ?? null;
        $cpf                = $data['cpf'] ?? null;
        $email              = $data['email'] ?? null;
        $telephone          = $data['telefone'] ?? null;

        $tipo_ordenacao     = $data['tipo_ordenacao'] ?? null;
        $campo_ordenacao    = $data['campo_ordenacao'] ?? null;
        $por_pagina         = $data['por_pagina'] ?? 20;

        return $this->model
            ->when(isset($name), fn($query)        => $query->where('name', 'LIKE', "%$name%"))
            ->when(isset($cpf), fn($query)         => $query->where('cpf', 'LIKE', "%$cpf%"))
            ->when(isset($email), fn($query)       => $query->where('email', 'LIKE', "%$email%"))
            ->when(isset($email), fn($query)       => $query->where('email', 'LIKE', "%$email%"))
            ->when(isset($telephone), fn($query)   => $query->where('telephone', 'LIKE', "%$telephone%"))
            ->when(
                !isset($campo_ordenacao) && !isset($tipo_ordenacao),
                fn($query) => $query->orderBy('created_at', 'DESC'),
                fn($query) => $query->orderBy($campo_ordenacao, $tipo_ordenacao)
            )
            ->paginate($por_pagina);
    }
}

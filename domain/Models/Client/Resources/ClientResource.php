<?php

namespace ERP\Models\Client\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource {

    public function toArray($request): array
    {
        return [
            'nome'              => $this->name,
            'documento'         => $this->cpf,
            'email'             => $this->email,
            'telefone'          => $this->telephone,
            'criado_em'         => $this->created_at,
            'atualizado_em'     => $this->updated_at,
            'uuid'              => $this->uuid,
        ];
    }
}

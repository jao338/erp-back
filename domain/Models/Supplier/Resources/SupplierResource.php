<?php

namespace ERP\Models\Supplier\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource {

    public function toArray($request): array
    {
        return [
            'nome'              => $this->name,
            'cnpj'              => $this->cnpj,
            'email'             => $this->email,
            'telephone'         => $this->telephone,
            'criado_em'         => $this->created_at,
            'atualizado_em'     => $this->updated_at,
            'uuid'              => $this->uuid,
        ];
    }
}

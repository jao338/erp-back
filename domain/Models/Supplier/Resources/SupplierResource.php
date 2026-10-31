<?php

namespace ERP\Models\Supplier\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource {

    public function toArray($request): array
    {
        return [
            'person_type'       => $this->person->person_type,
            'nome'              => $this->person->name,
            'cpf'               => $this->person->cpf,
            'cnpj'              => $this->person->cnpj,
            'email'             => $this->person->email,
            'telephone'         => $this->person->telephone,
            'criado_em'         => $this->created_at,
            'atualizado_em'     => $this->updated_at,
            'uuid'              => $this->uuid,
        ];
    }
}

<?php

namespace ERP\Models\Sale\Resources;

use ERP\Models\SaleItem\Resources\SaleItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource {

    public function toArray($request): array
    {
        return [
            'uuid'              => $this->uuid,
            'criado_em'         => $this->created_at,
            'atualizado_em'     => $this->updated_at,
            'ativo'             => $this->active,
            'lucro'             => $this->profit,
            'cliente'           => $this->client?->name,
            'itens'             => SaleItemResource::collection($this->saleItems),
        ];
    }
}

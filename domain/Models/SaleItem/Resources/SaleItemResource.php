<?php

namespace ERP\Models\SaleItem\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SaleItemResource extends JsonResource {

    public function toArray($request): array
    {
        return [
            'uuid'              => $this->uuid,
            'produto'           => $this->product?->name,
            'quantidade'        => $this->amount,
            'preco_unitario'    => $this->unit_price,
            'custo_unitario'    => $this->unit_cost,
            'subtotal'          => $this->subtotal,
            'lucro'             => $this->profit,
        ];
    }
}

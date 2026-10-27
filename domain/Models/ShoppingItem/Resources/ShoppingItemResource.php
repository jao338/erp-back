<?php

namespace ERP\Models\ShoppingItem\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingItemResource extends JsonResource {

    public function toArray($request): array
    {
        return [
            'uuid'              => $this->uuid,
            'preco_unitario'    => $this->unit_price,
            'subtotal'          => $this->subtotal,
            'produto'           => $this->product?->name,
            'produto_uuid'      => $this->product?->uuid,
        ];
    }
}

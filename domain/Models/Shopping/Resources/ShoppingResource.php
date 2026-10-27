<?php

namespace ERP\Models\Shopping\Resources;

use ERP\Models\ShoppingItem\Resources\ShoppingItemResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ShoppingResource extends JsonResource {

    public function toArray($request): array
    {
        return [
            'uuid'             => $this->uuid,
            'total'            => $this->total,
            'fornecedor'       => $this->supplier?->name,
            'items'            => ShoppingItemResource::collection($this->shoppingItems),
            'criado_em'        => $this->created_at,
            'atualizado_em'    => $this->updated_at,
        ];
    }
}

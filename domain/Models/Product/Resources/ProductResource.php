<?php

namespace ERP\Models\Product\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource {

    public function toArray($request): array
    {
        return [
            'nome'             => $this->name,
            'custo_medio'      => $this->average_cost,
            'preco_venda'      => $this->sale_price,
            'quantidade'       => $this->amount,
            'criado_em'        => $this->created_at,
            'atualizado_em'    => $this->updated_at,
            'uuid'             => $this->uuid,
        ];
    }
}

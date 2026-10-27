<?php

namespace ERP\Models\Sale\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'cliente_uuid'              => ['required', 'uuid', 'exists:client,uuid'],
            'itens'                     => ['required', 'array', 'min:1'],
            'itens.*.produto_uuid'      => ['required', 'uuid', 'exists:product,uuid'],
            'itens.*.quantidade'        => ['required', 'integer', 'gt:0'],
            'itens.*.preco_unitario'    => [
                'required',
                'numeric',
                'gt:0',
            ],
        ];
    }
}

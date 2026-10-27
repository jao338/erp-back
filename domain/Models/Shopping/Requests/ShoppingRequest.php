<?php

namespace ERP\Models\Shopping\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShoppingRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'fornecedor_uuid' => [
                'required',
                'uuid',
                'exists:supplier,uuid'
            ],
            'itens' => [
                'array',
                'required',
                'min:1'
            ],
            'itens.*.produto_uuid'      => ['required', 'exists:product,uuid', 'uuid'],
            'itens.*.quantidade'        => ['required', 'integer', 'min:1'],
            'itens.*.preco_unitario'    => ['required', 'numeric', 'gt:0'],
        ];
    }
}

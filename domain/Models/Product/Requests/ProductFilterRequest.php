<?php

namespace ERP\Models\Product\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'nome' => [
                'string',
                'max:255',
            ],
            'custo_medio' => [
                'numeric',
            ],
            'preco_venda' => [
                'numeric',
            ],
            'quantidade' => [
                'integer',
            ],
            'criado_em' => [
                'date',
            ],
            'atualizado_em' => [
                'date',
            ],
        ];
    }
}

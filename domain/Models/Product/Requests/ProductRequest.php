<?php

namespace ERP\Models\Product\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest {

    public function rules(): array
    {
        $nomeRules = [
            'required',
            'string',
            'min:3',
            'max:50',
        ];

        if ($this->isMethod('post')) {
            $nomeRules[] = Rule::unique('product', 'name');
        }

        return [
            'nome' => $nomeRules,

            'custo_medio' => [
                'required',
                'decimal:2',
                'gt:0',
            ],

            'preco_venda' => [
                'required',
                'decimal:2',
                'gt:0',
            ],

            'quantidade' => [
                'nullable',
                'integer',
            ],
        ];
    }
}

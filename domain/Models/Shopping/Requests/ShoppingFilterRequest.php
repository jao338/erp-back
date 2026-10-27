<?php

namespace ERP\Models\Shopping\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShoppingFilterRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'total' => [
              'numeric'
            ],
            'criado_em' => [
                'datetime',
            ],
            'atualizado_em' => [
                'datetime',
            ],
        ];
    }
}

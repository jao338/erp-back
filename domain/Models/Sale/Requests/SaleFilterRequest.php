<?php

namespace ERP\Models\Sale\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleFilterRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'total' => [
              'numeric'
            ],
            'criado_em' => [
                'date',
            ],
            'atualizado_em' => [
                'date',
            ],
            'ativo' => [
                'boolean',
            ],
            'lucro' => [
                'numeric',
            ],
        ];
    }
}

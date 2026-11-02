<?php

namespace ERP\Models\Supplier\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SupplierFilterRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'nome' => [
                'string',
                'max:255',
            ],
            'email' => [
                'string',
            ],
            'cnpj' => [
                'string',
                'max:14',
            ],
            'cpf' => [
                'string',
                'max:11',
            ],
            'telefone' => [
                'string',
            ],
            'campo_ordenacao' => [
                'sometimes',
                'nullable',
                'string',
                Rule::in(['created_at', 'updated_at', 'uuid']),
            ],
            'tipo_ordenacao' => [
                'sometimes',
                'nullable',
                'string',
                Rule::in(['ASC', 'DESC']),
            ],
        ];
    }
}

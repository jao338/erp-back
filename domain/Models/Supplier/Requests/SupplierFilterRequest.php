<?php

namespace ERP\Models\Supplier\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
                'email',
            ],
            'cnpj' => [
                'string',
                'max:14',
            ],
            'telephone' => [
                'integer',
            ],
        ];
    }
}

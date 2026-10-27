<?php

namespace ERP\Models\Client\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientFilterRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'nome' => [
                'string',
                'max:255',
            ],
            'cpf' => [
                'string',
                'max:11',
            ],
            'email' => [
                'string',
                'email',
            ],
            'telefone' => [
                'integer'
            ],
        ];
    }
}

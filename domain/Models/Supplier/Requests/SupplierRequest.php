<?php

namespace ERP\Models\Supplier\Requests;

use ERP\Enums\PersonType;
use ERP\Rules\VerifyIfIsCNPJRule;
use ERP\Rules\VerifyIfIsCPFRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use ERP\Models\Supplier\Supplier;

class SupplierRequest extends FormRequest
{
    public function rules(): array
    {
        $personId = null;
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $personId = Supplier::where('uuid', $this->route('uuid'))->value('person_id');
        }

        return [
            'tipo' => [
                'required',
                Rule::enum(PersonType::class),
            ],
            'nome' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('person', 'name')->ignore($personId),
            ],
            'cpf' => [
                'bail',
                'nullable',
                'string',
                'size:11',
                'required_if:tipo,1',
                'prohibited_if:tipo,2',
                new VerifyIfIsCPFRule(),
                Rule::unique('person', 'cpf')->ignore($personId),
            ],
            'cnpj' => [
                'bail',
                'nullable',
                'string',
                'size:14',
                'required_if:tipo,2',
                'prohibited_if:tipo,1',
                new VerifyIfIsCNPJRule(),
                Rule::unique('person', 'cnpj')->ignore($personId),
            ],
            'email' => [
                'nullable',
                'string',
                'email',
            ],
            'telefone' => [
                'nullable',
                'string',
                'max:13',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'cpf.required_if'    => 'O CPF é obrigatório para pessoa física.',
            'cpf.prohibited_if'  => 'O CPF não deve ser informado para pessoa jurídica.',
            'cpf.string'         => 'O CPF deve ser informado como texto.',
            'cpf.size'           => 'O CPF deve conter 11 caracteres.',
            'cnpj.required_if'   => 'O CNPJ é obrigatório para pessoa jurídica.',
            'cnpj.prohibited_if' => 'O CNPJ não deve ser informado para pessoa física.',
            'cnpj.string'        => 'O CNPJ deve ser informado como texto.',
            'cnpj.size'          => 'O CNPJ deve conter 14 caracteres.',
        ];
    }
}

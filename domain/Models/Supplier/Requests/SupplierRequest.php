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
}

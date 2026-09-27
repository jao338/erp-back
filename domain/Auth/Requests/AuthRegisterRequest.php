<?php

namespace Base\Auth\Requests;

use App\Rules\VerifyIFFirstAccessRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'email' => [
                'bail',
                'required',
                'email',
                'exists:user,email',
                new VerifyIFFirstAccessRule()
            ],
        ];
    }
}

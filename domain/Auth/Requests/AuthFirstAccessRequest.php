<?php

namespace Base\Auth\Requests;

use App\Rules\VerifyIFFirstAccessRule;
use Base\Base\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthFirstAccessRequest extends FormRequest
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

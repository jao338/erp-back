<?php

namespace Base\Auth\Requests;

use App\Rules\VerifyIFFirstAccessRule;
use Base\Base\Rules\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class AuthVerifyCodeAccessRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'integer',
                'between:10000,99999',
            ],
            'email' => [
                'required',
                'email',
                'exists:user,email',
            ],
        ];
    }
}

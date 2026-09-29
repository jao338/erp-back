<?php

namespace Base\Auth\Requests;

use App\Rules\VerifyIFFirstAccessRule;
use Base\Base\Rules\PasswordRule;
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
            ],
            'name' => [
                'required',
                'string',
                'min:2'
            ],
            'password' => [
                'required',
                'string',
                new PasswordRule($this->input('password')),
            ],
            'confirm_password' => [
                'required',
                'string',
                'same:password',
            ],
        ];
    }
}

<?php

namespace ERP\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PasswordRule implements ValidationRule {

    public function __construct(protected ?string $password = null) {}

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $password = (string) $value;

        // Pelo menos: 8 chars, 1 maiúscula, 1 número, 1 caractere especial
        $pattern = '/^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';

        if (!preg_match($pattern, $password)) {
            $fail('A senha deve conter ao menos 8 caracteres, uma letra maiúscula, um número e um caractere especial.');
        }
    }

}

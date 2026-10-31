<?php

namespace ERP\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VerifyIfIsCNPJRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        if (!is_string($value) || !isCNPJ($value)) {
            $fail('O campo :attribute deve conter um CNPJ válido.');
        }
    }
}

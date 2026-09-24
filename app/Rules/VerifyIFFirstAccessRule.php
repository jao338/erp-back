<?php

namespace App\Rules;

use Base\Models\User\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class VerifyIFFirstAccessRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $user = User::where('email', $value)->first();

        if($user->verify_at){
            $fail(__('messages.user_verified'));
        }
    }
}

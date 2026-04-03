<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class IndonesianPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    // public function validate(string $attribute, mixed $value, Closure $fail): void
    // {
    //     //
    // }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^(\+62|62|0)8[1-9][0-9]{7,10}$/', $value)) {
            $fail("Format nomor HP tidak valid.");
        }
    }

    // public function passes($attribute, $value)
    // {
    //     return preg_match('/^(\+62|62|0)8[1-9][0-9]{7,10}$/', $value);
    //     // Regex untuk +62, 62, atau 08
    // }
}

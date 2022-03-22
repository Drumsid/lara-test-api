<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Luna implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $nums = strrev(preg_replace('/[^\d]/','',$value));

        $sum = 0;
        for ($i = 0, $j = strlen($nums); $i < $j; $i++) {
            if (($i % 2) == 0) {
                $val = $nums[$i];
            } else {
                $val = $nums[$i] * 2;
                if ($val > 9)  $val -= 9;
            }
            $sum += $val;
        }

        return (($sum % 10) == 0);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Not valid card number.';
    }
}

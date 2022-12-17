<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BirthDateRule implements Rule
{
    const MAX_YEAR = 100;
    const MIN_YEAR = 16;
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
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return ($value < now()->subYears(self::MIN_YEAR)) &&
            ($value > now()->subYears(self::MAX_YEAR));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Selected date is not allowed';
    }
}

<?php


namespace App\Rules\DNS;


abstract class Rule implements \Illuminate\Contracts\Validation\Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    abstract public function passes($attribute, $value);

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'This DNS record is invalid.';
    }
}

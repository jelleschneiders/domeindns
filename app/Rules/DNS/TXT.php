<?php

namespace App\Rules\DNS;

class TXT extends Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return preg_match("/^(\")(.+)(\")$/", $value);
    }

}

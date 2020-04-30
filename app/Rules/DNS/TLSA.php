<?php

namespace App\Rules\DNS;

class TLSA extends Rule
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
        return preg_match("/^([0-3])( )([01])( )([0-2])( )([a-zA-Z0-9]{64,64})$/", $value);
    }

}

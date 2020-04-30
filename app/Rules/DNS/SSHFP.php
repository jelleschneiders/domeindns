<?php

namespace App\Rules\DNS;

class SSHFP extends Rule
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
        return preg_match("/^([1-4])( )([12])( )([a-zA-Z0-9]{40,64})$/", $value);
    }

}

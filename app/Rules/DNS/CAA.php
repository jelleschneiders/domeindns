<?php

namespace App\Rules\DNS;

class CAA extends Rule
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
        return preg_match("/^([01])( )(\bissue|\bissuewild|\biodef)( )(\")(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}(\")$/", $value);
    }

}

<?php

namespace App\Rules\DNS;

class SPF extends Rule
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

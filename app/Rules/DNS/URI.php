<?php

namespace App\Rules\DNS;

class URI extends Rule
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
        return preg_match("/^(([0-9]|[1-8][0-9]|9[0-9]|100)( )([0-9]|[1-8][0-9]|9[0-9]|100)( \")([a-zA-Z.:\/]+)(\"))$/", $value);
    }

}

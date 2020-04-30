<?php

namespace App\Rules;

use App\Zone;
use Illuminate\Contracts\Validation\Rule;
use Pdp\Cache;
use Pdp\CurlHttpClient;
use Pdp\Manager;
use Pdp\Rules;

class Domain implements Rule
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
        $manager = new Manager(new Cache(), new CurlHttpClient());
        $rules = $manager->getRules();
        $domain = $rules->resolve($value);
        $formatteddomain = $domain->getRegistrableDomain();

        $zone = Zone::where('domain', $formatteddomain)->get();

        if($value != $formatteddomain){
            return false;
        }

        if($zone->count() == 0){
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This is not a valid domain or this domain already exists.';
    }
}

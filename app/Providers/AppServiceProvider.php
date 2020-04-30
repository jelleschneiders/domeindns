<?php

namespace App\Providers;

use App\Zone;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Pdp\Cache;
use Pdp\CurlHttpClient;
use Pdp\Manager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ConfigSettingsService;


/**
 * Class ConfigServiceProvider
 * @package App\Providers
 */
class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() : void
    {
        $configLoader = new ConfigSettingsService($this->app->environment());
        $configLoader->load();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() : void
    {

    }
}

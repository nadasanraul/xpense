<?php

namespace App\Api\Auth\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

/**
 * Class RouteServiceProvider
 * @package App\Api\Auth\Providers
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Api\Auth\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapOauthRoutes();

        $this->mapAuthRoutes();
    }


    /**
     * Defines the oauth routes for the application
     *
     * @return void
     */
    protected function mapOauthRoutes()
    {
        Route::prefix('api/oauth')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(app_path('Api/Auth/Routes/oauth.php'));
    }

    /**
     * Defines the auth routes for the application
     *
     * @return void
     */
    protected function mapAuthRoutes()
    {
        Route::prefix('api/auth')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(app_path('Api/Auth/Routes/auth.php'));
    }
}

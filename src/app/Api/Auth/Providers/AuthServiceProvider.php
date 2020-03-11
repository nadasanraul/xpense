<?php

namespace App\Api\Auth\Providers;

use Laravel\Passport\Passport;
use App\Api\Auth\Grants\SocialGrant;
use Illuminate\Database\Eloquent\Factory;
use Laravel\Passport\Bridge\UserRepository;
use League\OAuth2\Server\AuthorizationServer;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Class AuthServiceProvider
 * @package App\Api\Auth\Providers
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Registering the application data
     *
     * @return void
     */
    public function register()
    {
        // Register providers
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerConfig();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path('Auth', 'Database/Migrations'));

        Passport::tokensExpireIn(now()->addYear());
        Passport::refreshTokensExpireIn(now()->addYear()->addWeek());

        app(AuthorizationServer::class)->enableGrantType(
            $this->makeSocialGrant(),
            Passport::tokensExpireIn()
        );
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path('Auth', 'Config/config.php') => config_path('auth.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path('Auth', 'Config/config.php'), 'auth'
        );
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(module_path('Auth', 'Database/factories'));
        }
    }

    /**
     * Create new social grant
     *
     * @return SocialGrant
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    private function makeSocialGrant()
    {
        $grant = new SocialGrant(
            $this->app->make(UserRepository::class),
            $this->app->make(RefreshTokenRepository::class)
        );

        $grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());

        return $grant;
    }
}

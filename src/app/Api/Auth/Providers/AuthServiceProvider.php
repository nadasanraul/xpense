<?php

namespace App\Api\Auth\Providers;

use Laravel\Passport\Passport;
use App\Api\Auth\Grants\SocialGrant;
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

        Passport::tokensExpireIn(now()->addYear());
        Passport::refreshTokensExpireIn(now()->addYear()->addWeek());

        app(AuthorizationServer::class)->enableGrantType(
            $this->makeSocialGrant(),
            Passport::tokensExpireIn()
        );
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

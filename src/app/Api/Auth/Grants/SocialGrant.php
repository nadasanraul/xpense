<?php

namespace App\Api\Auth\Grants;

use DateInterval;
use App\Api\Auth\Models\User;
use League\OAuth2\Server\RequestEvent;
use Laravel\Socialite\Facades\Socialite;
use Psr\Http\Message\ServerRequestInterface;
use League\OAuth2\Server\Grant\AbstractGrant;
use Laravel\Socialite\Two\User as SocialiteUser;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\ResponseTypes\ResponseTypeInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use Laravel\Passport\Bridge\User as PassportUser;

/**
 * Class SocialGrant
 * @package App\Grants
 */
class SocialGrant extends AbstractGrant
{
    /**
    * @param UserRepositoryInterface         $userRepository
    * @param RefreshTokenRepositoryInterface $refreshTokenRepository
    */
    public function __construct(
        UserRepositoryInterface $userRepository,
        RefreshTokenRepositoryInterface $refreshTokenRepository
    ) {
        $this->setUserRepository($userRepository);
        $this->setRefreshTokenRepository($refreshTokenRepository);

        $this->refreshTokenTTL = new DateInterval('P1M');
    }

    /**
     * The grand identifier
     *
     * @return string
     */
    public function getIdentifier()
    {
        return 'social_grant';
    }

    /**
     * @inheritDoc
     */
    public function respondToAccessTokenRequest(
        ServerRequestInterface $request,
        ResponseTypeInterface $responseType,
        DateInterval $accessTokenTTL
    )
    {
        // Validate request
        $client = $this->validateClient($request);
        $scopes = $this->validateScopes($this->getRequestParameter('scope', $request, $this->defaultScope));
        $user = $this->validateUser($request, $client);

        // Finalize the requested scopes
        $finalizedScopes = $this->scopeRepository->finalizeScopes($scopes, $this->getIdentifier(), $client, $user->getIdentifier());

        // Issue and persist new access token
        $accessToken = $this->issueAccessToken($accessTokenTTL, $client, $user->getIdentifier(), $finalizedScopes);
        $this->getEmitter()->emit(new RequestEvent(RequestEvent::ACCESS_TOKEN_ISSUED, $request));
        $responseType->setAccessToken($accessToken);

        // Issue and persist new refresh token if given
        $refreshToken = $this->issueRefreshToken($accessToken);

        if ($refreshToken !== null) {
            $this->getEmitter()->emit(new RequestEvent(RequestEvent::REFRESH_TOKEN_ISSUED, $request));
            $responseType->setRefreshToken($refreshToken);
        }

        return $responseType;
    }

    /**
     * Validating the user exists in the system
     *
     * @param ServerRequestInterface $request
     * @param ClientEntityInterface  $client
     *
     * @return UserEntityInterface|null
     * @throws OAuthServerException
     */
    protected function validateUser(ServerRequestInterface $request, ClientEntityInterface $client)
    {
        $code = $this->getRequestParameter('code', $request);

        if (is_null($code)) {
            throw OAuthServerException::invalidRequest('code');
        }

        $driver = $this->getRequestParameter('driver', $request);

        if (is_null($driver)) {
            throw OAuthServerException::invalidRequest('driver');
        }

        /** @var SocialiteUser $socialiteUser */
        $socialiteUser = Socialite::driver($driver)->stateless()->user();

        $appUser = User::where('email', $socialiteUser->getEmail())->first();

        $user = new PassportUser($appUser->getAuthIdentifier());

        if ($user instanceof UserEntityInterface === false) {
            $this->getEmitter()->emit(new RequestEvent(RequestEvent::USER_AUTHENTICATION_FAILED, $request));

            throw OAuthServerException::invalidGrant();
        }

        return $user;
    }
}

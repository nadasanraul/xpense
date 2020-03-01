<?php

namespace App\Api\Auth\Http\Middleware;

use Closure;
use App\Api\Auth\Models\OAuthClient;

/**
 * Class InjectGrantCredentials
 * @package App\Api\Auth\Http\Middleware
 */
class InjectGrantCredentials
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (in_array($request->get('grant_type'), ['social_grant', 'refresh_token'])) {
            $origin = $request->hasHeader('Origin') ? $request->headers->get('Origin') : $request->getSchemeAndHttpHost();

            $client = OAuthClient::where('domain', $origin)->first();

            if (is_null($client)) {
                return $this->getUnauthorizedResponse();
            }

            $request->merge([
                'client_id' => $client->id,
                'client_secret' => $client->secret,
            ]);

            return $next($request);
        }

        return $this->getUnauthorizedResponse();
    }

    /**
     * The unauthorized response
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function getUnauthorizedResponse()
    {
        return response()->json('Unauthorized', 401);
    }
}

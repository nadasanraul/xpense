<?php

namespace App\Api\Auth\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class LoginController
 * @package App\Api\Auth\Http\Controllers
 */
class LoginController extends Controller
{
    /**
     * Login controller action
     *
     * @param string $driver
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(string $driver)
    {
        try {
            return Socialite::driver($driver)->stateless()->redirect();
        } catch (\Throwable $e) {
            return response()->json([
                'error' => true,
            ]);
        }
    }

    /**
     * Handles the redirect from the auth provider
     *
     * @param string $driver
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function handleRedirect(string $driver)
    {
        try {
            $code = request()->get('code');
            $request = Request::create(
                '/api/oauth/token',
                'POST',
                [
                    'grant_type' => 'social_grant',
                    'code' => $code,
                    'driver' => $driver,
                ]
            );

            return app()->handle($request);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => true,
            ]);
        }
    }
}

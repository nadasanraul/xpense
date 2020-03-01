<?php

namespace App\Api\Auth\Http\Controllers;

use Psr\Http\Message\ServerRequestInterface;
use Laravel\Passport\Http\Controllers\AccessTokenController;

/**
 * Class OAuthController
 * @package App\Http\Controllers
 */
class OAuthController extends AccessTokenController
{
    /**
     * Issue the access and refresh tokens
     *
     * @param ServerRequestInterface $request
     *
     * @return \Illuminate\Http\Response
     */
    public function issueToken(ServerRequestInterface $request)
    {
        return parent::issueToken($request);
    }
}

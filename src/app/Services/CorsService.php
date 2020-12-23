<?php

namespace App\Services;

use App\Api\Auth\Models\OAuthClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CorsService
 * @package Auth\Classes
 */
class CorsService
{
    /**
     * @var array $options
     */
    private $options;

    /**
     * CorsService constructor.
     */
    public function __construct()
    {
        $this->options = $this->normalizeOptions(config('cors'));
    }

    /**
     * Normalize Options
     *
     * @param array $options
     * @return array
     */
    private function normalizeOptions(array $options = array())
    {
        // normalize array('*') to true
        if (in_array('*', $options['allowedOrigins'])) {
            $options['allowedOrigins'] = true;
        }
        if (in_array('*', $options['allowedHeaders'])) {
            $options['allowedHeaders'] = true;
        } else {
            $options['allowedHeaders'] = array_map('strtolower', $options['allowedHeaders']);
        }

        if (in_array('*', $options['allowedMethods'])) {
            $options['allowedMethods'] = true;
        } else {
            $options['allowedMethods'] = array_map('strtoupper', $options['allowedMethods']);
        }

        return $options;
    }

    /**
     * Check if the actual request is allowed
     *
     * @param Request $request
     * @return bool
     */
    public function isActualRequestAllowed(Request $request)
    {
        return $this->checkOrigin($request);
    }

    /**
     * Check if the request is cross domain
     *
     * @param Request $request
     * @return bool
     */
    public function isCorsRequest(Request $request)
    {
        return $request->headers->has('Origin') && !$this->isSameHost($request);
    }

    /**
     * Check if the request is preflight
     * @param Request $request
     * @return bool
     */
    public function isPreflightRequest(Request $request)
    {
        return $this->isCorsRequest($request)
            && $request->getMethod() === 'OPTIONS'
            && $request->headers->has('Access-Control-Request-Method');
    }

    /**
     * Added Header if the request is cross domain
     *
     * @param Request $request
     * @return void
     */
    public function addActualRequestHeaders(Request $request)
    {
        if ($this->checkOrigin($request)) {
            header('Access-Control-Allow-Origin: ' . $request->headers->get('Origin'));
        }

        if ($this->isSameHost($request)) {
            header('Access-Control-Allow-Origin: ' . $request->getSchemeAndHttpHost());
        }

        header('Access-Control-Allow-Methods: PATCH, GET, PUT, POST, DELETE, UPDATE, OPTIONS');
        header('Vary: Accept-Encoding, Origin');
        header('Access-Control-Allow-Headers: X-Requested-With, X-PINGOTHER, Authorization, Content-Type, Accept, Set-Cookie');
        header('Access-Control-Allow-Credentials: true');
    }

    /**
     * Handle all the preflight requests
     *
     * @param Request $request
     * @return bool|Response
     */
    public function handlePreflightRequest(Request $request)
    {
        if (true !== $check = $this->checkPreflightRequestConditions($request)) {
            return $check;
        }

        return $this->buildPreflightCheckResponse($request);
    }

    /**
     * Add headers for the preflight response
     *
     * @param Request $request
     * @return Response
     */
    private function buildPreflightCheckResponse(Request $request)
    {
        $response = new Response();

        if ($this->options['supportsCredentials']) {
            $response->headers->set('Access-Control-Allow-Credentials', 'true');
        }

        $response->headers->set('Access-Control-Allow-Origin', $request->headers->get('Origin'));

        if ($this->options['maxAge']) {
            $response->headers->set('Access-Control-Max-Age', $this->options['maxAge']);
        }

        $allowMethods = $this->options['allowedMethods'] === true
            ? strtoupper($request->headers->get('Access-Control-Request-Method'))
            : implode(', ', $this->options['allowedMethods']);
        $response->headers->set('Access-Control-Allow-Methods', $allowMethods);

        $allowHeaders = $this->options['allowedHeaders'] === true
            ? strtoupper($request->headers->get('Access-Control-Request-Headers'))
            : implode(', ', $this->options['allowedHeaders']);
        $response->headers->set('Access-Control-Allow-Headers', $allowHeaders);

        return $response;
    }

    /**
     * Check the preflight if it matches the correct conditions
     *
     * @param Request $request
     * @return bool|Response
     */
    private function checkPreflightRequestConditions(Request $request)
    {
        if (!$this->checkOrigin($request)) {
            return $this->createBadRequestResponse(403, 'Origin not allowed');
        }

        if (!$this->checkMethod($request)) {
            return $this->createBadRequestResponse(405, 'Method not allowed');
        }

        // if allowedHeaders has been set to true ('*' allow all flag) just skip this check
        if ($this->options['allowedHeaders'] !== true && $request->headers->has('Access-Control-Request-Headers')) {
            $headers        = strtolower($request->headers->get('Access-Control-Request-Headers'));
            $requestHeaders = array_filter(explode(',', $headers));

            foreach ($requestHeaders as $header) {
                if (!in_array(trim($header), $this->options['allowedHeaders'])) {
                    return $this->createBadRequestResponse(403, 'Header not allowed');
                }
            }
        }

        return true;
    }

    /**
     * Create a BadRequest Response
     *
     * @param $code
     * @param string $reason
     * @return Response
     */
    private function createBadRequestResponse($code, $reason = '')
    {
        return new Response($reason, $code);
    }

    /**
     * Check if the request is on the same domain
     *
     * @param Request $request
     * @return bool
     */
    public function isSameHost(Request $request)
    {
        return $request->headers->get('Origin') === $request->getSchemeAndHttpHost();
    }

    /**
     * Check if the Origin of the request is allowed
     *
     * @param Request $request
     * @return bool
     */
    private function checkOrigin(Request $request)
    {
        if ($this->options['allowedOrigins'] === true) {
            // allow all '*' flag
            return true;
        }

        $origin = $request->headers->get('Origin');

        if (count($this->options['allowedOrigins']) && in_array($origin, $this->options['allowedOrigins'])) {
            return true;
        }

        if (OAuthClient::where('domain', '=', $origin)->where('password_client', 1)->count() > 0) {
            return true;
        };

        foreach ($this->options['allowedOriginsPatterns'] as $pattern) {
            if (preg_match($pattern, $origin)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if the request method is allowed
     *
     * @param Request $request
     * @return bool
     */
    private function checkMethod(Request $request)
    {
        if ($this->options['allowedMethods'] === true) {
            // allow all '*' flag
            return true;
        }

        $requestMethod = strtoupper($request->headers->get('Access-Control-Request-Method'));
        return in_array($requestMethod, $this->options['allowedMethods']);
    }
}

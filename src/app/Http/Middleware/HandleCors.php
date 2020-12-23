<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\CorsService;

/**
 * Class HandleCors
 * @package App\Http\Middleware
 */
class HandleCors
{
    /**
     * @var CorsService $cors
     */
    protected $cors;

    /**
     * HandleCors constructor.
     * @param CorsService $cors
     */
    public function __construct(CorsService $cors)
    {
        $this->cors = $cors;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! $this->cors->isCorsRequest($request)) {
            return $next($request);
        }

        if ($this->cors->isPreflightRequest($request)) {
            return $this->cors->handlePreflightRequest($request);
        }

        if (!$this->cors->isActualRequestAllowed($request)) {
            return new Response('Not allowed in CORS policy.', 403);
        }

        $this->cors->addActualRequestHeaders($request);

        return $next($request);
    }
}

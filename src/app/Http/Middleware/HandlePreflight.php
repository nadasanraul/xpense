<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\CorsService;

/**
 * Class PreflightResponse
 * @package App\Http\Middleware
 */
class HandlePreflight
{
    /**
     * @var CorsService $cors
     */
    protected $cors;

    /**
     * HandlePreflight constructor.
     * @param CorsService $cors
     */
    public function __construct(CorsService $cors)
    {
        $this->cors = $cors;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next )
    {
        if ($this->cors->isPreflightRequest($request)) {
            return $this->cors->handlePreflightRequest($request);
        }

        return $next($request);
    }
}

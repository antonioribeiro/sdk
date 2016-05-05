<?php

namespace PragmaRX\Sdk\Services\Caching\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PragmaRX\Sdk\Services\Caching\Service\Facade as Caching;

class After extends Base
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $key = $this->keygen($request->url());

        if (! Caching::has($key))
        {
            Caching::put($key, $response->getContent(), config('env.CACHE_RESPONSE_TIME', 60));
        }

        return $response;
    }
}

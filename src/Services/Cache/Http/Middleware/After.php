<?php

namespace App\Services\Cache\Http\Middleware;

use Str;
use Cache;
use Closure;

class After extends Base
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $key = $this->keygen($request->url());

        if (! Cache::has($key))
        {
            Cache::put($key, $response->getContent(), config('env.CACHE_RESPONSE_TIME', 60));
        }

        return $response;
    }
}

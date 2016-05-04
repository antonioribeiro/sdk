<?php

namespace App\Services\Cache\Http\Middleware;

use Str;
use Cache;
use Closure;

class Before extends Base
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
        $key = $this->keygen($request->url());

        if(Cache::has($key))
        {
            return Cache::get( $key );
        }

        return $next($request);
    }
}

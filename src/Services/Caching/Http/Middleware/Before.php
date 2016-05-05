<?php

namespace PragmaRX\Sdk\Services\Caching\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PragmaRX\Sdk\Services\Caching\Service\Facade as Caching;

class Before extends Base
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
        $key = $this->keygen($request->url());

        if(Caching::has($key))
        {
            return response(Caching::get($key));
        }

        return $next($request);
    }
}

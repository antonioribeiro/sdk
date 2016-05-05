<?php

namespace PragmaRX\Sdk\Services\Caching\Http\Middleware;

use Illuminate\Support\Str;

class Base
{
    protected function keygen($url)
    {
        return 'route_' . Str::slug($url);
    }
}

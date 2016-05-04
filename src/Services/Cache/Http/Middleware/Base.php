<?php

namespace App\Services\Cache\Http\Middleware;

class Base
{
    protected function keygen( $url )
    {
        return 'route_' . Str::slug( $url );
    }
}

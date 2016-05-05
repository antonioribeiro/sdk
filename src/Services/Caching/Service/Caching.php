<?php

namespace PragmaRX\Sdk\Services\Caching\Service;

use PragmaRX\Sdk\Core\Traits\CachableTrait;
use Illuminate\Contracts\Cache\Repository as IlluminateCacheRepository;

class Caching
{
    use CachableTrait;

    /**
     * @var \Illuminate\Contracts\Cache\Factory
     */
    private $cache;

    public function __construct(IlluminateCacheRepository $cache)
    {
        $this->cache = $cache;
    }

	public function __call($name, $arguments)
	{
        return call_user_func_array([$this->cache, $name] , $arguments);
	}
}

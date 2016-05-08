<?php

namespace PragmaRX\Sdk\Core\Data\Repositories;

use Config;
use PragmaRX\Sdk\Core\Data\Repositories\Traits\Find;
use PragmaRX\Sdk\Core\Data\Repositories\Traits\Model;
use PragmaRX\Sdk\Core\Data\Repositories\Traits\Helpers;
use PragmaRX\Sdk\Core\Data\Repositories\Traits\Caching;
use PragmaRX\Sdk\Services\Caching\Service\Caching as CachingService;

abstract class Repository
{
    use Find;
    use Model;
    use Helpers;
    use Caching;

    /**
     * @var string
     */
    protected $model = '';

    /**
     * @var \PragmaRX\Sdk\Services\Caching\Service\Caching
     */
    protected $caching;

    public function __construct(CachingService $caching)
    {
        $this->caching = $caching;
    }

	protected function call($className, $method = null, $arguments = [])
	{
		return call($this->getClassName($className), $method, $arguments);
	}
}

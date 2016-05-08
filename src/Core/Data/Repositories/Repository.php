<?php

namespace PragmaRX\Sdk\Core\Data\Repositories;

use Config;
use PragmaRX\Sdk\Core\Data\Repositories\Traits\Find;
use PragmaRX\Sdk\Core\Data\Repositories\Traits\Model;
use PragmaRX\Sdk\Core\Data\Repositories\Traits\Helpers;

class Repository
{
    use Find;
    use Model;
    use Helpers;

	protected $model = '';

	protected function call($className, $method = null, $arguments = [])
	{
		return call($this->getClassName($className), $method, $arguments);
	}
}

<?php

namespace PragmaRX\Sdk\Services\Ocr\Service;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'pragmarx.config';
	}

}

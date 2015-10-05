<?php

namespace PragmaRX\Sdk\Services\Form\Service;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class HtmlFacade extends LaravelFacade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'pragmarx.html';
	}

}

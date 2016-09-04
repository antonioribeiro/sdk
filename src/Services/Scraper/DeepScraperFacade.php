<?php namespace PragmaRX\Sdk\Services\Scraper;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class DeepScraperFacade extends LaravelFacade {

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'pragmarx.deep.scraper';
	}

}

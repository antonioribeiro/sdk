<?php

namespace PragmaRX\SDK\Routing;

use Controller as LaravelController;
use Laracasts\Commander\CommanderTrait;

class Controller extends LaravelController {

	use CommanderTrait;

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

}

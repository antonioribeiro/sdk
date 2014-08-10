<?php

namespace PragmaRX\SDK\Core;

use Controller as IlluminateController;
use Laracasts\Commander\CommanderTrait;

class Controller extends IlluminateController {

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

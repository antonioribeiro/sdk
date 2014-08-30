<?php

namespace PragmaRX\Sdk\Core;

use Illuminate\Routing\Controller as IlluminateController;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\DispatchableTrait;

class Controller extends IlluminateController {

	use CommanderTrait;
	use DispatchableTrait;

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

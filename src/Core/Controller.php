<?php

namespace PragmaRX\Sdk\Core;

use Laracasts\Commander\CommanderTrait;
use Laracasts\Commander\Events\DispatchableTrait;
use Response;

class Controller {

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

	public function success()
	{
		return Response::json(['success' => true]);
	}

}

<?php

namespace PragmaRX\Sdk\Core;

use Response;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as IlluminateController;

class Controller extends IlluminateController {

	use DispatchesCommands, ValidatesRequests;

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

	public function success($additional = [])
	{
		return Response::json(array_merge(['success' => true], $additional));
	}

	public function execute($class, $input = [])
	{
		$request = app('request');

		return $this->dispatchFrom($class, $request, $input);
	}

}

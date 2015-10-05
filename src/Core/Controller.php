<?php

namespace PragmaRX\Sdk\Core;

use Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use PragmaRX\Sdk\Core\Validation\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as IlluminateController;

class Controller extends IlluminateController
{
	use DispatchesJobs, AuthorizesRequests, ValidatesRequests;

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

<?php

namespace PragmaRX\SDK\Messaging;

use PragmaRX\SDK\Core\Controller as BaseController;
use Redirect;
use Session;
use View;

class Controller extends BaseController {

	/**
	 * Display the password reminder view.
	 *
	 * @return Response
	 */
	public function index()
	{
		if ( ! Session::get('message'))
		{
			return Redirect::home();
		}

		return View::make('messages.index')
				->with('title', Session::get('title'))
				->with('message', Session::get('message'))
				->with('buttons', Session::get('buttons'));
	}

}

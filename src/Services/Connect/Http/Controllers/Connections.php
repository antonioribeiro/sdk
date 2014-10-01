<?php

namespace PragmaRX\Sdk\Services\Connect\Http\Controllers;

use PragmaRX\Sdk\Core\Redirect;
use PragmaRX\Sdk\Core\Controller as BaseController;

use Auth;
use Flash;
use View;

class Connections extends BaseController {

	public function index()
	{
		$connetions = Auth::user()->connections()->paginate();

		return View::make('connections.index')->with('connections', $connetions);
	}

}

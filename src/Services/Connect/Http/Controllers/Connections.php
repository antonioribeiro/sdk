<?php

namespace PragmaRX\Sdk\Services\Connect\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use PragmaRX\Sdk\Core\Redirect;
use PragmaRX\Sdk\Core\Controller as BaseController;

use Auth;
use Flash;
use View;

class Connections extends BaseController {

	public function index()
	{
		$connetions = new LengthAwarePaginator(Auth::user()->connections, count(Auth::user()->connections()), 15);

		return View::make('connections.index')->with('connections', $connetions);
	}

}

<?php

namespace PragmaRX\Sdk\Services\Clipping\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use PragmaRX\Sdk\Core\Controller as BaseController;

use Auth;
use Flash;
use View;

class Clippingions extends BaseController {

	public function index()
	{
		$connetions = new LengthAwarePaginator(Auth::user()->connections, count(Auth::user()->connections()), 15);

		return View::make('connections.index')->with('connections', $connetions);
	}

}

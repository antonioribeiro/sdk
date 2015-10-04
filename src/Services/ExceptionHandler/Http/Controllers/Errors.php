<?php

namespace PragmaRX\Sdk\Services\ExceptionHandler\Http\Controllers;

use Redirect;
use PragmaRX\Sdk\Core\Controller as BaseController;

class Errors extends BaseController
{
	public function show($code)
	{
		return view('errors.'.$code);
	}
}

<?php

namespace PragmaRX\Sdk\Services\Products\Http\Controllers;

use PragmaRX\Sdk\Core\Controller as BaseController;

class Products extends BaseController
{
	public function index()
	{
		return view('clipping.posts');
	}
}

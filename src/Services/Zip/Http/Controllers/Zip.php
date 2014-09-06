<?php

namespace PragmaRX\Sdk\Services\Zip\Http\Controllers;

use ZIPCode;
use PragmaRX\Sdk\Core\Controller as BaseController;
use Request;
use Response;

class Zip extends BaseController {

	public function search($zip)
	{
		$result = ZIPCode::find($zip);

		if ($result->success)
		{
			$result = ['success' => true] + $result->addresses[0];
		}
		else
		{
			$result = ['success' => false];
		}

		if (Request::ajax())
		{
			return Response::json($result);
		}

		return Response::make($result);
	}

}

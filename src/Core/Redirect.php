<?php

namespace PragmaRX\SDK\Core;

use Response;
use Request;

class Redirect {

	public static function __callstatic($name, array $parameters = [])
	{
		if (Request::ajax())
		{
			$response = [
				'result' => $parameters,
				'success' => true,
			];

			return Response::json($response);
		}

		if ($name == 'back')
		{
			return static::back($parameters);
		}

		return static::call($name, $parameters);
	}

	private static function back($parameters)
	{
		$referer = Request::instance()->headers->get('referer');

		if ( ! $referer)
		{
			return static::call('home', $parameters);
		}

		return static::call('back', $parameters);
	}

	private static function call($name, $parameters)
	{
		return call_user_func_array(
			'Illuminate\Support\Facades\Redirect::' . $name,
			$parameters
		);
	}

}

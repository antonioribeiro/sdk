<?php

namespace PragmaRX\Sdk\Core;

use Response;
use Request;
use Input;

class Redirect {

	/**
	 * @param $name
	 * @param array $parameters
	 * @return \Illuminate\Http\JsonResponse|mixed
	 */
	public static function __callstatic($name, array $parameters = [])
	{
		if (Request::ajax())
		{
			if ($name == 'route')
			{
				$response = [
					'redirect' => route_ajax(
						$parameters[0],
						isset($parameters[1]) ? $parameters[1] : null
					)
			    ];
			}
			else
			{
				$response = [
					'result' => $parameters,
					'success' => true,
				];
			}

			return Response::json($response);
		}

		if ($name == 'back')
		{
			return static::back($parameters);
		}

		return static::call($name, $parameters);
	}

	/**
	 * @param $parameters
	 * @return mixed
	 */
	private static function back($parameters)
	{
		$referer = static::__getReferer();

		if ( ! $referer || static::__isBadReferer($referer))
		{
			return static::call('home', $parameters);
		}

		array_unshift($parameters, $referer);

		return static::call('to', $parameters);
	}

	/**
	 * @param $name
	 * @param $parameters
	 * @return mixed
	 */
	private static function call($name, $parameters)
	{
		return call_user_func_array(
			'Illuminate\Support\Facades\Redirect::' . $name,
			$parameters
		);
	}

	/**
	 * @return array|mixed|string
	 */
	public static function __getReferer()
	{
		if ( ! $referer = Input::get('referer-url'))
		{
			$referer = Request::instance()->headers->get('referer');
		}

		if (static::__isBadReferer($referer))
		{
			$referer = convert_url_to_ajax(Request::getUri());
		}

		return $referer;
	}

	/**
	 * @param $referer
	 * @return bool
	 */
	public static function __isBadReferer($referer)
	{
		return Request::method() != 'GET' && $referer == self::__getOrigin();
	}

	/**
	 * @return string
	 */
	private static function __getOrigin()
	{
		$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

		return "$origin/";
	}

}

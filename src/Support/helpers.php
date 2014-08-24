<?php

if ( ! function_exists('explode_attributes'))
{
	function explode_attributes($attributes = null)
	{
		if ( ! isset($attributes) || ! is_array($attributes))
		{
			return $attributes;
		}

		return
			implode(' ', array_map(
					function($prop, $value)
					{
						return $prop.'="'.$value.'"';
					},
					array_keys($attributes),
					$attributes
				)
			);
	}
}

if ( ! function_exists( 't' ))
{
	function t($string, $replace = array(), $locale = null)
	{
		return get_lang_string($string, $replace, $locale);
	}
}

if ( ! function_exists( 'p' ))
{
	function p($string, $number, array $replace = array(), $locale = null)
	{
		$string = get_lang_string($string, $replace, $locale);

		return \Lang::choice($string, $number);
	}
}

if ( ! function_exists( 'get_lang_string' ))
{
	function get_lang_string($key, $replace = array(), $locale = null)
	{
		$string = \Lang::get($key, $replace, $locale);

		if ($string == $key)
		{
			$string = Lang::get("pragmarx/sdk::$key", $replace, $locale);
		}

		return $string;
	}
}

if ( ! function_exists( 'route_ajax' ))
{
	function route_ajax($route, $parameters = array())
	{
		$string = convert_url_to_ajax(route($route, $parameters));

		return $string;
	}
}

if ( ! function_exists( 'convert_url_to_ajax' ))
{
	function convert_url_to_ajax($url)
	{
		$domain = getenv('DOMAIN');

		$pos = strpos($url, $domain);

		$url = substr($url, 0, $pos + strlen($domain) + 1) .
			'#' . /// add the ajax url handler
			substr($url, $pos + strlen($domain));

		return $url;
	}
}



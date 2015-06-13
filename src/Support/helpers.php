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
		return \Lang::get($key, $replace, $locale);
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
		$domain = \Request::getHost();

		$pos = strpos($url, $domain);

		$parsed = parse_url($url);

		$path = isset($parsed['path']) ? $parsed['path'] : '/';

		if ($path !== '/')
		{
			$url = substr($url, 0, $pos + strlen($domain) + 1) .
					'#' . /// add the ajax url handler
					substr($url, $pos + strlen($domain));
		}

		return $url;
	}
}

if ( ! function_exists( 'var_log' ))
{
	function var_log(&$varInput, $var_name = '', $reference = '', $method = '=', $sub = false)
	{
		static $output;
		static $depth;

		if ($sub == false)
		{
			$output = '';
			$depth = 0;
			$reference = $var_name;
			$var = serialize($varInput);
			$var = unserialize($var);
		}
		else
		{
			++$depth;
			$var =& $varInput;

		}

		// constants
		$nl = "\n";
		$block = 'a_big_recursion_protection_block';

		$c = $depth;
		$indent = '';
		while ($c-- > 0)
		{
			$indent .= '|  ';
		}

		// if this has been parsed before
		if (is_array($var) && isset($var[$block]))
		{

			$real =& $var[$block];
			$name =& $var['name'];
			$type = gettype($real);
			$output .= $indent . $var_name . ' ' . $method . '& ' . ($type == 'array'
					? 'Array'
					: get_class($real)) . ' ' . $name . $nl;

			// havent parsed this before
		}
		else
		{

			// insert recursion blocker
			$var = Array($block => $var, 'name' => $reference);
			$theVar =& $var[$block];

			// print it out
			$type = gettype($theVar);
			switch ($type)
			{

				case 'array' :
					$output .= $indent . $var_name . ' ' . $method . ' Array (' . $nl;
					$keys = array_keys($theVar);
					foreach ($keys
					         as
					         $name)
					{
						$value =& $theVar[$name];
						var_log($value, $name, $reference . '["' . $name . '"]', '=', true);
					}
					$output .= $indent . ')' . $nl;
					break;

				case 'object' :
					$output .= $indent . $var_name . ' = ' . get_class($theVar) . ' {' . $nl;
					foreach ($theVar
					         as
					         $name
					=>
					         $value)
					{
						var_log($value, $name, $reference . '->' . $name, '->', true);
					}
					$output .= $indent . '}' . $nl;
					break;

				case 'string' :
					$output .= $indent . $var_name . ' ' . $method . ' "' . $theVar . '"' . $nl;
					break;

				default :
					$output .= $indent . $var_name . ' ' . $method . ' (' . $type . ') ' . $theVar . $nl;
					break;

			}

			// $var=$var[$block];

		}

		--$depth;

		if ($sub == false)
			return $output;

	}
}

if ( ! function_exists( 'getContrastYIQ' ))
{
	function getContrastYIQ($hexcolor)
	{
		if ($hexcolor[0] == '#')
		{
			$hexcolor = substr($hexcolor, 1);
		}

		$r = hexdec(substr($hexcolor, 0, 2));
		$g = hexdec(substr($hexcolor, 2, 2));
		$b = hexdec(substr($hexcolor, 4, 2));
		$yiq = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;
		return ($yiq >= 128)
			? 'black'
			: 'white';
	}
}

if ( ! function_exists( 'adjustBrightness' ))
{
	function adjustBrightness($hex, $steps)
	{
		// Steps should be between -255 and 255. Negative = darker, positive = lighter
		$steps = max(-255, min(255, $steps));

		// Format the hex color string
		$hex = str_replace('#', '', $hex);
		if (strlen($hex) == 3)
		{
			$hex = str_repeat(substr($hex, 0, 1), 2) . str_repeat(substr($hex, 1, 1), 2) . str_repeat(
					substr($hex, 2, 1), 2
				);
		}

		// Get decimal values
		$r = hexdec(substr($hex, 0, 2));
		$g = hexdec(substr($hex, 2, 2));
		$b = hexdec(substr($hex, 4, 2));

		// Adjust number of steps and keep it inside 0 to 255
		$r = max(0, min(255, $r + $steps));
		$g = max(0, min(255, $g + $steps));
		$b = max(0, min(255, $b + $steps));

		$r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
		$g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
		$b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

		return '#' . $r_hex . $g_hex . $b_hex;
	}
}

if ( ! function_exists( 'array_translate' ))
{
	function array_translate($data)
	{
		foreach ($data as $key => $value)
		{
			$data[$key] = t($data[$key]);
		}

		return $data;
	}
}

if ( ! function_exists( 'uuid' ))
{
	function uuid()
	{
		return (string) Rhumsaa\Uuid\Uuid::uuid4();
	}
}

if ( ! function_exists( 'upper' ))
{
	function upper($string)
	{
		return Illuminate\Support\Str::upper($string);
	}
}

if ( ! function_exists( 'lower' ))
{
	function lower($string)
	{
		return Illuminate\Support\Str::lower($string);
	}
}

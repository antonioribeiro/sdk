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

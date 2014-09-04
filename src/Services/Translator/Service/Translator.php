<?php

namespace PragmaRX\Sdk\Services\Translator\Service;

use Illuminate\Translation\Translator as IlluminateTranslator;

class Translator extends IlluminateTranslator {

	public function get($key, array $replace = array(), $locale = null)
	{
		$string = parent::get($key, $replace, $locale);

		if ($string == $key)
		{
			$packageKey = "pragmarx/sdk::$key";

			$string = parent::get($packageKey, $replace, $locale);

			if ($string === $packageKey)
			{
				$string = $key;
			}
		}

		return $string;
	}

}

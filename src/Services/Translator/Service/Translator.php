<?php

namespace PragmaRX\Sdk\Services\Translator\Service;

use Illuminate\Translation\Translator as IlluminateTranslator;

class Translator extends IlluminateTranslator {

	public function get($key, array $replace = array(), $locale = null)
	{
		$locale = $this->getCurrentLocale($locale);

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

	private function getCurrentLocale($locale)
	{
		if ( ! $locale)
		{
			if ( ! $locale = app()->make('session')->get('locale'))
			{
				if ( ! app()->make('auth')->check() || ! $locale = app()->make('auth')->user()->locale)
				{
					$locale = app()->make('config')['app.locale'];
				}
			}
		}

		return $locale;
	}

}

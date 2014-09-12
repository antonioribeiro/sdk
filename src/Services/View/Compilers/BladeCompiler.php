<?php

namespace PragmaRX\Sdk\Services\View\Compilers;

use Illuminate\View\Compilers\BladeCompiler as IlluminateBladeCompiler;

use Config;

class BladeCompiler extends IlluminateBladeCompiler {

	public function isExpired($path)
	{
		if (Config::get('view.cache') === false)
		{
			return true;
		}

		return parent::isExpired($path);
	}

}

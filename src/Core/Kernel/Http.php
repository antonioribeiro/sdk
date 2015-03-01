<?php

namespace PragmaRX\Sdk\Core\Kernel;

use Illuminate\Foundation\Http\Kernel as IlluminateHttpKernel;

class Http extends IlluminateHttpKernel {

	/**
	 * Get the bootstrap classes for the application.
	 *
	 * @return array
	 */
	protected function bootstrappers()
	{
		$key = array_search('Illuminate\Foundation\Bootstrap\LoadConfiguration', $this->bootstrappers);

		$this->bootstrappers[$key] = 'PragmaRX\Sdk\Core\Foundation\Bootstrap\LoadConfiguration';

		return $this->bootstrappers;
	}

}

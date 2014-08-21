<?php

namespace PragmaRX\SDK\Services\Files\File;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

use PragmaRX\SDK\Services\Files\File\Service as File;

class ServiceProvider extends IlluminateServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['pragmarx.files'] = $this->app->share(function($app)
		{
			return new File;
		});
	}

}

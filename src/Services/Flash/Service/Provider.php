<?php

namespace PragmaRX\Sdk\Services\Flash\Service;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class Provider extends IlluminateServiceProvider {

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
		$this->app['pragmarx.flash'] = $this->app->share(function($app)
		{
			return new Flash;
		});
	}

}

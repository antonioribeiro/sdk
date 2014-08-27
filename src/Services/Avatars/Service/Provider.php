<?php

namespace PragmaRX\Sdk\Services\Avatars\Service;

use PragmaRX\Support\ServiceProvider;

class Provider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	protected $defaultBinding = 'pragmarx.avatars';

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app[$this->defaultBinding] = $this->app->share(function($app)
		{
			return new Avatar;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [$this->defaultBinding];
	}

}

<?php namespace PragmaRX\Sdk\Services\Auth\Service;

use PragmaRX\Support\ServiceProvider;
use PragmaRX\Sdk\Services\Auth\Service\Auth;

class Provider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['pragmarx.auth'] = $this->app->share(function($app)
		{
			return new Auth;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['pragmarx.auth'];
	}
}

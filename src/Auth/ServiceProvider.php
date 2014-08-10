<?php namespace PragmaRX\SDK\Auth;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use PragmaRX\SDK\Auth\Service as Auth;

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
		$this->app['pragmarx.auth'] = $this->app->share(function($app)
		{
			return new Auth;
		});
	}

}

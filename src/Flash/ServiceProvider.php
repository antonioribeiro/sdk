<?php namespace PragmaRX\SDK\Flash;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use PragmaRX\SDK\Flash\Service as Flash;

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
		$this->app['pragmarx.flash'] = $this->app->share(function($app)
		{
			return new Flash;
		});
	}

}

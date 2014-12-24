<?php namespace PragmaRX\Sdk\Services\Push\Service;

use PragmaRX\Support\ServiceProvider;
use PragmaRX\Sdk\Services\Push\Service\Push;

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
		$this->app['pragmarx.push'] = $this->app->share(function($app)
		{
			return new Push(env('PUSH.PUBLIC'), env('PUSH.SECRET'), env('PUSH.APP_ID'));
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['pragmarx.push'];
	}
}

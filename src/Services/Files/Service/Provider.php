<?php

namespace PragmaRX\Sdk\Services\Files\Service;

use PragmaRX\Support\ServiceProvider;

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
		$this->app['pragmarx.files'] = $this->app->share(function($app)
		{
			return app()->make(File::class);
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['pragmarx.files'];
	}

	/**
	 * Get the current package directory.
	 *
	 * @return string
	 */
	public function getPackageDir()
	{
		return __DIR__;
	}

}

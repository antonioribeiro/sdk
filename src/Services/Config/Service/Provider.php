<?php

namespace PragmaRX\Sdk\Services\Config\Service;

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
		$this->registerConfig();
	}

	private function registerConfig()
	{
		// Instantiate and copy Laravel's config
		$config = new Config();

		// Override Laravel's config IoC binding
		$this->app->bindShared('config', function($app) use ($config)
		{
			return $config;
		});
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['pragmarx.config', 'config'];
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

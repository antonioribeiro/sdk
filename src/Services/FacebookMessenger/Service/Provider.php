<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Service;

use PragmaRX\Support\ServiceProvider;

class Provider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

	protected $defaultBinding = 'pragmarx.facebook_messenger';

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton($this->defaultBinding, function($app)
		{
			return new FacebookMessenger(
                config('env.TELEGRAM_BOT_NAME'),
                config('env.TELEGRAM_BOT_TOKEN')
            );
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

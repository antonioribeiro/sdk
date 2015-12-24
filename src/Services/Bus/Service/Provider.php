<?php

namespace PragmaRX\Sdk\Services\Bus\Service;

use PragmaRX\Support\ServiceProvider;

class Provider extends ServiceProvider
{
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
		$this->checkLaravelConflict();

		$this->app->singleton('AltThree\Bus', function($app)
		{
			return new Dispatcher($app, function() use ($app)
			{
				return $app['Illuminate\Contracts\Queue\Queue'];
			});
		});

		$this->app->alias(
			'AltThree\Bus', 'Illuminate\Contracts\Bus\Dispatcher'
		);

		$this->app->alias(
			'AltThree\Bus', 'Illuminate\Contracts\Bus\QueueingDispatcher'
		);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [
			'AltThree\Bus',
			'Illuminate\Contracts\Bus\Dispatcher',
			'Illuminate\Contracts\Bus\QueueingDispatcher',
		];
	}

	public function getPackageDir()
	{
		return __DIR__;
	}

	private function checkLaravelConflict()
	{
		if (array_search(\Illuminate\Bus\BusServiceProvider::class, config('app.providers')))
		{
			echo 'If you want to use ' . __CLASS__ . ',<br>';
			echo 'please disable Laravel BusServiceProvider on your config';
			die;
		}
	}
}

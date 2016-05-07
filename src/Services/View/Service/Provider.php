<?php

namespace PragmaRX\Sdk\Services\View\Service;

use PragmaRX\Support\ServiceProvider;
use PragmaRX\Sdk\Services\View\Compilers\BladeCompiler;

class Provider extends ServiceProvider {

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
		$app = $this->app;

		$app->singleton('blade.compiler', function($app)
		{
			$cache = $app['config']['view.compiled'] ?: $app['path.storage'].'/views';

			return app()->make(BladeCompiler::class, [$app['files'], $cache]);
		});

		$this->app->make('view')->addExtension('blade.jsx', 'blade');
		$this->app->make('view')->addExtension('blade.js', 'blade');
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

<?php

namespace PragmaRX\Sdk\Services\View\Service;

use Illuminate\View\FileViewFinder;
use PragmaRX\Sdk\Services\View\Compilers\BladeCompiler;
use PragmaRX\Support\ServiceProvider;

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

		$app->bindShared('blade.compiler', function($app)
		{
			$cache = $app['path.storage'].'/views';

			return new BladeCompiler($app['files'], $cache);
		});

		$this->app->make('view')->addExtension('blade.jsx', 'blade');
		$this->app->make('view')->addExtension('blade.js', 'blade');
	}

}

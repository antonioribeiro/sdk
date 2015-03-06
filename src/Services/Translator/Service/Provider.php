<?php

namespace PragmaRX\Sdk\Services\Translator\Service;

use PragmaRX\Support\ServiceProvider;
use Illuminate\Translation\FileLoader;

class Provider extends ServiceProvider {

	protected $iocAliases = ['translator', 'translation.loader'];

	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->registerLoader();

		$this->app->singleton($this->iocAliases, function($app)
		{
			$loader = $app['translation.loader'];

			// When registering the translator component, we'll need to set the default
			// locale as well as the fallback locale. So, we'll grab the application
			// configuration so we can easily get both of these values from there.
			$locale = $app['config']['app.locale'];

			$trans = new Translator($loader, $locale);

			$trans->setFallback($app['config']['app.fallback_locale']);

			return $trans;
		});
	}

	protected function registerLoader()
	{
		$this->app->singleton('translation.loader', function($app)
		{
			return new FileLoader($app['files'], $app['path.lang']);
		});
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

<?php

namespace PragmaRX\SDK;

use App;
use PragmaRX\Support\ServiceProvider as PragmaRXServiceProvider;

class ServiceProvider extends PragmaRXServiceProvider {

    protected $packageVendor = 'pragmarx';
    protected $packageVendorCapitalized = 'PragmaRX';

    protected $packageName = 'sdk';
    protected $packageNameCapitalized = 'SDK';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected function wakeUp()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
	    $this->preRegister();

	    $this->registerConfig();

	    $this->registerServiceProviders();

	    $this->registerServices();

	    $this->registerGlobalExceptionHandlers();

	    $this->configurePackages();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('pragmarx.sdk');
    }

    public function registerConfig()
    {
        $this->app['tracker.config'] = $this->app->share(function($app)
        {
            return new Config($app['config'], self::PACKAGE_NAMESPACE);
        });
    }

	private function registerServiceProviders()
	{
		$disabled_packages = $this->getConfig('disabled.packages') ?: [];

		foreach($this->getConfig('packages') as $package)
		{
			$this->registerServiceProvider($package, $disabled_packages);
		}
	}

	private function loadFacades($package)
	{
		if ( ! isset($package['facades']))
		{
			return;
		}

		foreach($package['facades'] as $name => $class)
		{
			$this->loadFacade($name, $class);
		}
	}

	private function includeServiceScripts($services = null)
	{
		foreach($services as $service)
		{
			$this->includeFile(__DIR__ . "/$service/routes.php");

			$this->includeFile(__DIR__ . "/$service/handlers.php");

			$this->includeFile(__DIR__ . "/$service/events.php");

			$this->includeFile(__DIR__ . "/$service/listeners.php");
		}
	}

	/**
	 * Gets the root directory of the child ServiceProvider
	 *
	 * @return string
	 */
	protected function getRootDirectory()
	{
		return __DIR__;
	}

	/**
	 * @param $package
	 */
	private function registerServiceProvider($package, $disabled_packages = [])
	{
		if ($package['enabled']
			&& ! in_array($package['name'], $disabled_packages)
			&& class_exists($class = $package['serviceProvider']))
		{
			App::register($class);

			$this->loadFacades($package);
		}
	}

	private function registerServices()
	{
		$services = $this->getConfig('services');

		$this->includeServiceScripts($services);
	}

	/**
	 * @param $file
	 */
	private function includeFile($file)
	{
		if (file_exists($file))
		{
			include $file;
		}
	}

	private function registerGlobalExceptionHandlers()
	{
		$this->includeFile(__DIR__ . "/App/handlers.php");

		$this->includeFile(__DIR__ . "/App/filters.php");
	}

	private function configurePackages()
	{
		$this->app['config']->set('cartalyst/sentinel::users.model', $this->getConfig('models.user'));
	}
}

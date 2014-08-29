<?php

namespace PragmaRX\Sdk;

use App;
use PragmaRX\Sdk\Core\Migrations\MigrateCommand;
use PragmaRX\Sdk\Core\Migrations\RollbackCommand;
use PragmaRX\Sdk\Core\Traits\ServiceableTrait;
use PragmaRX\Support\ServiceProvider as PragmaRXServiceProvider;

use File;

class ServiceProvider extends PragmaRXServiceProvider {

	use ServiceableTrait;

    protected $packageVendor = 'pragmarx';
    protected $packageVendorCapitalized = 'PragmaRX';

    protected $packageName = 'sdk';
    protected $packageNameCapitalized = 'Sdk';

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
	    $this->preRegister();

	    $this->registerConfig();

	    $this->registerServiceProviders();

	    $this->registerServices();

	    $this->registerGlobalScripts();

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
        $this->app['pragmarx.config'] = $this->app->share(function($app)
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

	private function includeServiceScripts($services, $path = null)
	{
		foreach($services as $service)
		{
			$this->includeSupportFiles($service, $path);
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
		if (isset($package['serviceProvider'])
			&& class_exists($class = $package['serviceProvider'])
			&& $package['enabled']
			&& ! in_array($package['name'], $disabled_packages))
		{
			App::register($class);
		}

		$this->loadFacades($package);
	}

	private function registerServices()
	{
		$services = $this->getConfig('services');

		// SDK Services
		$this->includeServiceScripts($services);

		// Application Services
		$this->includeServiceScripts(
			$this->getApplicationServices(),
			$this->getConfig('application_services_path')
		);

		$this->registerCommands();
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

	private function registerGlobalScripts()
	{
		$this->includeFile(__DIR__ . "/Sdk/App/bootstrap/start.php");

		$this->includeFile(__DIR__ . "/Sdk/Errors/handlers.php");

		$this->includeFile(__DIR__ . "/Sdk/HTTP/filters.php");

		$this->includeFile(__DIR__ . "/Support/helpers.php");

		$this->includeFile(__DIR__ . "/Support/blade.php");
	}

	private function configurePackages()
	{
		$this->app['config']->set('cartalyst/sentinel::users.model', $this->getConfig('models.user'));
	}

	private function includeSupportFiles($service, $path = null)
	{
		$path = $path ?: __DIR__;

		$loadable = [
			'routes.php',
			'filters.php',
			'listeners.php',
			'handlers.php',
			'events.php',
		];

		$files = App::make('files')->allFiles("{$path}/{$service}");

		foreach($files as $file)
		{
			if (in_array($file->getFileName(), $loadable))
			{
				include $file->getPathName();
			}
		}
	}

	private function registerCommands()
	{
		$this->app->bindShared('command.migrate', function($app)
		{
			$packagePath = $app['path.base'].'/vendor';

			return new MigrateCommand($app['migrator'], $packagePath);
		});

		$this->app->bindShared('command.migrate.rollback', function($app)
		{
			return new RollbackCommand($app['migrator']);
		});
	}

}

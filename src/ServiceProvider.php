<?php

namespace PragmaRX\Sdk;

use PragmaRX\Sdk\Core\Migrations\MigrateCommand;
use PragmaRX\Sdk\Core\Migrations\ResetCommand;
use PragmaRX\Sdk\Core\Migrations\RollbackCommand;
use PragmaRX\Sdk\Core\Traits\ServiceableTrait;
use PragmaRX\Support\ServiceProvider as PragmaRXServiceProvider;

use Language;

class ServiceProvider extends PragmaRXServiceProvider {

	use ServiceableTrait;

	/**
	 * Vendor name.
	 *
	 * @var string
	 */
	protected $packageVendor = 'pragmarx';

	/**
	 * Vendor name capitalized.
	 *
	 * @var string
	 */
	protected $packageVendorCapitalized = 'PragmaRX';

	/**
	 * Package name.
	 *
	 * @var string
	 */
	protected $packageName = 'sdk';

	/**
	 * Package name capitalized.
	 *
	 * @var string
	 */
	protected $packageNameCapitalized = 'Sdk';

	/**
	 * Internal boot method.
	 *
	 */
	public function wakeUp()
	{
		$this->registerGlobalScripts();

		$this->configureLocale();
	}

    /**
     * Register all the things.
     *
     * @return void
     */
    public function register()
    {
	    parent::register();

	    $this->registerPackages();

	    $this->registerServices();

	    $this->registerCommands();

	    $this->configurePackages();
    }

	/**
	 * Register all packages service providers.
	 *
	 */
	private function registerPackages()
	{
		$disabled_packages = $this->getConfig('disabled.packages') ?: [];

		foreach ($this->getConfig('packages') as $package)
		{
			if ( ! in_array($package['name'], $disabled_packages))
			{
				$this->registerPackageServiceProviders($package);

				$this->registerPackageFacades($package);
			}
		}
	}

	/**
	 * Load a package Facade.
	 *
	 * @param $package
	 */
	private function registerPackageFacades($package)
	{
		$facades = ! isset($package['facades'])
					? []
					: $package['facades'];

		foreach ($facades as $name => $class)
		{
			$this->loadFacade($name, $class);
		}
	}

	/**
	 * Include service scripts.
	 *
	 * @param array $services
	 * @param null $path
	 */
	private function includeServiceScripts(array $services, $path = null)
	{
		foreach ($services as $service)
		{
			$this->registerServiceScripts($service, $path);

			$this->registerServiceServiceProviders($service, $path);
		}
	}

	/**
	 * Register a package service provider.
	 *
	 * @param $package
	 */
	private function registerPackageServiceProviders($package)
	{
		$serviceProviders = ! isset($package['serviceProviders'])
								? []
								: $package['serviceProviders'];

		foreach ($serviceProviders as $serviceProvider)
		{
			if (class_exists($serviceProvider) && $package['enabled'])
			{
				$this->app->register($serviceProvider);
			}
		}
	}

	/**
	 * Register SDK and Application services.
	 *
	 */
	private function registerServices()
	{
		// SDK Services
		$this->includeServiceScripts($this->getConfig('services'));

		// Application Services
		$this->includeServiceScripts(
			$this->getApplicationServices(),
			$this->getConfig('application_services_path')
		);
	}

	/**
	 * Include a .php file.
	 *
	 * @param $file
	 */
	private function includeFile($file)
	{
		if (file_exists($file))
		{
			include $file;
		}
	}

	/**
	 * Register global scripts.
	 *
	 */
	private function registerGlobalScripts()
	{
		$this->includeFile(__DIR__ . "/Core/Exceptions/handlers.php");

		$this->includeFile(__DIR__ . "/Sdk/App/bootstrap/start.php");

		$this->includeFile(__DIR__ . "/Sdk/Http/routes.php");

		$this->includeFile(__DIR__ . "/Sdk/Http/filters.php");

		$this->includeFile(__DIR__ . "/Sdk/Errors/handlers.php");

		$this->includeFile(__DIR__ . "/Support/helpers.php");

		$this->includeFile(__DIR__ . "/Support/blade.php");

		$this->includeFile(__DIR__ . "/Support/zip.php");

		$this->includeFile(__DIR__ . "/Support/validators.php");
	}

	/**
	 * Configure all packages.
	 *
	 */
	private function configurePackages()
	{
		$this->configureSentinel();
	}

	/**
	 * Configure Cartalyst Sentinel models.
	 *
	 * ***** THIS MUST BE EXTRACTED!
	 */
	private function configureSentinel()
	{
		$this->app['config']->set('cartalyst/sentinel::users.model', $this->getConfig('models.user'));

		$this->app['config']->set('cartalyst/sentinel::roles.model', $this->getConfig('models.role'));

	    $this->app['config']->set('cartalyst/sentinel::persistences.model', $this->getConfig('models.persistence'));

	    $this->app['config']->set('cartalyst/sentinel::activations.model', $this->getConfig('models.activation'));

	    $this->app['config']->set('cartalyst/sentinel::reminders.model', $this->getConfig('models.reminder'));

	    $this->app['config']->set('cartalyst/sentinel::throttling.model', $this->getConfig('models.throttle'));
	}

	/**
	 * Include all service support files.
	 *
	 * @param $service
	 * @param null $path
	 */
	private function registerServiceScripts($service, $path = null)
	{
		$path = $path ?: __DIR__;

		$loadable = [
			'routes.php',
			'filters.php',
			'listeners.php',
			'handlers.php',
			'events.php',
		];

		$files = $this->app->make('files')->allFiles("{$path}/{$service}");

		foreach ($files as $file)
		{
			if (in_array($file->getFileName(), $loadable))
			{
				include $file->getPathName();
			}
		}
	}

	/**
	 * Load Service Services Providers.
	 *
	 * @param $service
	 * @param null $path
	 */
	private function registerServiceServiceProviders($service, $path = null)
	{
		$path = $path ?: __DIR__;

		if (file_exists($providersPath = "$path/{$service}/Providers"))
		{
			$files = $this->app->make('files')->allFiles($providersPath);

			foreach ($files as $file)
			{
				$class = get_class_name_from_file($file, __DIR__, 'PragmaRX\Sdk');

				if (class_exists($class))
				{
					$this->app->register($class);
				}
			}
		}
	}

	/**
	 * Register Artisan commands.
	 *
	 */
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

		$this->app->bindShared('command.migrate.reset', function($app)
		{
			return new ResetCommand($app['migrator']);
		});
	}

	/**
	 * Configure the current Locale.
	 *
	 */
	private function configureLocale()
	{
		Language::configureLocale();
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

	/**
	 * Provides the root directory of the child ServiceProvider.
	 *
	 * @return string
	 */
	protected function getRootDirectory()
	{
		return __DIR__;
	}

}

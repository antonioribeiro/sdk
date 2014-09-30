<?php

namespace PragmaRX\Sdk;

use App;
use Auth;
use PragmaRX\Sdk\Core\Migrations\MigrateCommand;
use PragmaRX\Sdk\Core\Migrations\ResetCommand;
use PragmaRX\Sdk\Core\Migrations\RollbackCommand;
use PragmaRX\Sdk\Core\Traits\ServiceableTrait;
use PragmaRX\Support\ServiceProvider as PragmaRXServiceProvider;

use File;
use Session;
use Language;

class ServiceProvider extends PragmaRXServiceProvider {

	use ServiceableTrait;

    protected $packageVendor = 'pragmarx';
    protected $packageVendorCapitalized = 'PragmaRX';

    protected $packageName = 'sdk';
    protected $packageNameCapitalized = 'Sdk';

	public function wakeUp()
	{
		$this->registerGlobalScripts();

		$this->configureLocale();
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

	    $this->registerPackageServiceProviders();

	    $this->registerServices();

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

	private function registerPackageServiceProviders()
	{
		$disabled_packages = $this->getConfig('disabled.packages') ?: [];

		foreach($this->getConfig('packages') as $package)
		{
			$this->registerPackageServiceProvider($package, $disabled_packages);
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

			$this->loadServiceProviders($service, $path);
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
	private function registerPackageServiceProvider($package, $disabled_packages = [])
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

	private function configurePackages()
	{
		$this->app['config']->set('cartalyst/sentinel::users.model', $this->getConfig('models.user'));
		$this->app['config']->set('cartalyst/sentinel::roles.model', $this->getConfig('models.role'));
	    $this->app['config']->set('cartalyst/sentinel::persistences.model', $this->getConfig('models.persistence'));
	    $this->app['config']->set('cartalyst/sentinel::activations.model', $this->getConfig('models.activation'));
	    $this->app['config']->set('cartalyst/sentinel::reminders.model', $this->getConfig('models.reminder'));
	    $this->app['config']->set('cartalyst/sentinel::throttling.model', $this->getConfig('models.throttle'));
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

	private function loadServiceProviders($service, $path = null)
	{
		$path = $path ?: __DIR__;

		if (file_exists("$path/{$service}/Providers"))
		{
			$files = App::make('files')->allFiles("$path/{$service}/Providers");

			foreach($files as $file)
			{
				$class = get_class_name_from_file($file, __DIR__, 'PragmaRX\Sdk');

				if (class_exists($class))
				{
					App::register($class);
				}
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

		$this->app->bindShared('command.migrate.reset', function($app)
		{
			return new ResetCommand($app['migrator']);
		});
	}

	private function configureLocale()
	{
		Language::configureLocale();
	}

}

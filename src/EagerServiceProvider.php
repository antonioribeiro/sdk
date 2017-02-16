<?php

namespace PragmaRX\Sdk;

use Language;
use PragmaRX\Sdk\Core\Traits\ServiceableTrait;
use Illuminate\Foundation\AliasLoader as IlluminateAliasLoader;
use PragmaRX\Support\ServiceProvider as PragmaRXServiceProvider;

class EagerServiceProvider extends PragmaRXServiceProvider {

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
	 * Package name capitalized.
	 *
	 * @var string
	 */
	protected $defer = false;

	/**
	 * Boot the Service Provider.
	 *
	 */
	public function boot()
	{
		parent::boot();

		$this->registerGlobalScripts();

		$this->registerViews();

		$this->registerTranslations();
	}

	/**
	 * Register all the things.
	 *
	 * @return void
	 */
	public function register()
	{
		parent::register();

		if ($this->getConfig('enabled'))
		{
			$this->registerSdk();

			$this->registerPackages();

			$this->registerServices();

			$this->configurePackages();

			$this->registerAfterBootCalls();
		}
	}

	/**
	 * Register all packages service providers.
	 *
	 */
	private function registerPackages()
	{
		$disabled_packages = $this->getConfig('disabled_packages') ?: [];

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
			IlluminateAliasLoader::getInstance()->alias($name, $class);
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

			$this->registerServiceConsoleCommands($service, $path);
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
		if ( ! $this->getConfig('enabled'))
		{
			return false;
		}

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
		$this->app['config']->set('cartalyst/sentinel::users.model', $this->getConfig('aliases.user'));

		$this->app['config']->set('cartalyst/sentinel::roles.model', $this->getConfig('aliases.role'));

		$this->app['config']->set('cartalyst/sentinel::persistences.model', $this->getConfig('aliases.persistence'));

		$this->app['config']->set('cartalyst/sentinel::activations.model', $this->getConfig('aliases.activation'));

		$this->app['config']->set('cartalyst/sentinel::reminders.model', $this->getConfig('aliases.reminder'));

		$this->app['config']->set('cartalyst/sentinel::throttling.model', $this->getConfig('aliases.throttle'));
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
				if ($class = $this->getClassName($file))
				{
					$this->app->register($class);
				}
			}
		}
	}

	/**
	 * Load Service Console Commands.
	 *
	 * @param $service
	 * @param null $path
	 */
	private function registerServiceConsoleCommands($service, $path = null)
	{
		$path = $path ?: __DIR__;

		if (file_exists($commandsPath = "$path/{$service}/Console/Commands"))
		{
			$files = $this->app->make('files')->allFiles($commandsPath);

			foreach ($files as $file)
			{
				if (class_exists($class = get_class_and_namespace($file, true)))
				{
					$instance = $this->app->make($class);

					$this->app->singleton($class, function($app) use ($instance)
					{
						return $instance;
					});

					$this->commands($class);
				}
			}
		}
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

	private function registerAfterBootCalls()
	{
		$me = $this;

		$this->sdk->booted(function() use ($me)
		{
			$me->configureLocale();
		});
	}

	private function registerSdk()
	{
		$sdk = new Sdk();

		$this->sdk = $sdk;

		$this->app->singleton('pragmarx.sdk', function($app) use ($sdk)
		{
			return $sdk;
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

	private function registerViews()
	{
		$this->loadViewsFrom(__DIR__.'/views', 'pragmarx/sdk');
	}

	private function registerTranslations()
	{
		$this->loadTranslationsFrom(__DIR__.'/lang', 'pragmarx/sdk');
	}

	private function getClassName($file)
	{
		$class = get_class_and_namespace($file);

		if (count($class) > 1)
		{
			$class = $class[1] . '\\' . $class[0];
		}
		else
		{
			$class = $class[1];
		}

		if (class_exists($class))
		{
			return $class;
		}

		return false;
	}
}

<?php

namespace PragmaRX\Sdk;

use Language;
use PragmaRX\Sdk\Core\Migrations\ResetCommand;
use PragmaRX\Sdk\Core\Traits\ServiceableTrait;
use PragmaRX\Sdk\Core\Migrations\MigrateCommand;
use PragmaRX\Sdk\Core\Migrations\RollbackCommand;
use PragmaRX\Support\ServiceProvider as PragmaRXServiceProvider;

class LazyServiceProvider extends PragmaRXServiceProvider
{

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

	protected $defer = true;

	/**
	 * Boot the Service Provider.
	 *
	 */
	public function boot()
	{
		parent::boot();
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
			$this->registerCommands();
		}
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

	private function registerCommands()
	{
		$this->registerMigrationCommands();
	}

	/**
	 * Register Artisan commands.
	 *
	 */
	private function registerMigrationCommands()
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
	 * Provides the root directory of the child ServiceProvider.
	 *
	 * @return string
	 */
	protected function getRootDirectory()
	{
		return __DIR__;
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

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [
			'command.migrate',
			'command.migrate.rollback',
			'command.migrate.reset'
		];
	}
}

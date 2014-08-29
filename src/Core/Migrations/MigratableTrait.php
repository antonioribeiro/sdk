<?php

namespace PragmaRX\Sdk\Core\Migrations;

use App;
use File;
use PragmaRX\Sdk\Core\Traits\ServiceableTrait;

trait MigratableTrait {

	use ServiceableTrait;

	private $migrationPath;

	private $paths;

	private function getTemporaryMigrationPath()
	{
		if ( ! is_null($this->migrationPath))
		{
			return $this->migrationPath;
		}

		$this->paths[] = $this->getDefaultPath();

		if ( ! $this->getOption('package'))
		{
			$this->paths[] = base_path().'/database/migrations';

			$this->paths = array_merge($this->paths, $this->getServicesMigrationPaths());
		}

		$this->migrationPath = $this->getTemporaryPath();

		$this->copyMigrations($this->paths, $this->migrationPath);

		return $this->migrationPath;
	}

	private function getServicesMigrationPaths()
	{
		$services = App::make('config')->get('pragmarx/sdk::services');

		$applicationservicesPath = App::make('config')->get('pragmarx/sdk::application_services_path');

		$paths = [];

		// Get SDK migrations
		$paths = array_merge($paths, $this->getMigrationsPaths($services, __DIR__ . "/../../"));

		// Get Application migrations
		$paths = array_merge($paths, $this->getMigrationsPaths($this->getApplicationServices($applicationservicesPath), $applicationservicesPath));

		return $paths;
	}

	private function getMigrationsPaths($services, $directory)
	{
		$paths = [];

		foreach ($services as $service)
		{
			if ($path = $this->getServiceMigrationsPath($service, $directory))
			{
				$paths[] = $path;
			}
		}

		return $paths;
	}

	private function getServiceMigrationsPath($service, $directory)
	{
		$path = "{$directory}$service/Database/migrations";

		return file_exists($path) ? $path : null;
	}

	/**
	 * Get the path to the migration directory.
	 *
	 * @return string
	 */
	private function getDefaultPath()
	{
		$path = $this->getOption('path');

		// First, we will check to see if a path option has been defined. If it has
		// we will use the path relative to the root of this installation folder
		// so that migrations may be run for any path within the applications.
		if ( ! is_null($path))
		{
			return $this->laravel['path.base'].'/'.$path;
		}

		$package = $this->getOption('package');

		// If the package is in the list of migration paths we received we will put
		// the migrations in that path. Otherwise, we will assume the package is
		// is in the package directories and will place them in that location.
		if ( ! is_null($package))
		{
			return $this->packagePath.'/'.$package.'/src/migrations';
		}

		$bench = $this->getOption('bench');

		// Finally we will check for the workbench option, which is a shortcut into
		// specifying the full path for a "workbench" project. Workbenches allow
		// developers to develop packages along side a "standard" app install.
		if ( ! is_null($bench))
		{
			$path = "/workbench/{$bench}/src/migrations";

			return $this->laravel['path.base'].$path;
		}

		return $this->laravel['path'].'/database/migrations';
	}

	private function getOption($option)
	{
		return $this->input->hasOption($option)
				? $this->input->getOption($option)
				: null;
	}

	private function getTemporaryPath()
	{
		return File::tempDir();
	}

	private function copyMigrations($paths, $tempPath)
	{
		foreach($paths as $path)
		{
			if (file_exists($path))
			{
				foreach(File::allFiles($path) as $file)
				{
					File::copy($file->getPathName(), $tempPath . '/' . $file->getFileName());
				}
			}
		}
	}

	private function cleanTemporaryDirectory()
	{
		if (file_exists($this->migrationPath))
		{
			File::deleteDirectory($this->migrationPath);
		}
	}

} 

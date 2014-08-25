<?php

namespace PragmaRX\Sdk\Core\Migrations;

use App;
use File;
use Illuminate\Database\Console\Migrations\MigrateCommand as IlluminateMigrateCommand;

class MigrateCommand extends IlluminateMigrateCommand {

	protected $paths = [];

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		if ( ! $this->confirmToProceed()) return;

		$this->prepareDatabase();

		foreach($this->generateMigrationPaths() as $path)
		{
			$this->runMigration($path);
		}

		// Finally, if the "seed" option has been given, we will re-run the database
		// seed task to re-populate the database, which is convenient when adding
		// a migration and a seed at the same time, as it is only this command.
		if ($this->input->getOption('seed'))
		{
			$this->call('db:seed', ['--force' => true]);
		}
	}

	private function generateMigrationPaths()
	{
		$this->paths[] = $this->getMigrationPath();

		if ( ! $this->input->getOption('package'))
		{
			$this->paths = array_merge($this->paths, $this->getServicesMigrationPaths());
		}

		return $this->paths;
	}

	private function getServicesMigrationPaths()
	{
		$services = App::make('config')->get('pragmarx/sdk::services');

		$paths = [];

		foreach ($services as $service)
		{
			if ($path = $this->getServiceMigrationsPath($service))
			{
				$paths[] = $path;
			}
		}

		return $paths;
	}

	private function getServiceMigrationsPath($service)
	{
		foreach(File::allDirectories(__DIR__ . "/../../$service") as $directory)
		{
			if ($directory->getFileName() == 'migrations')
			{
				return $directory->getPathName();
			}
		}
	}

	private function runMigration($path)
	{
		// The pretend option can be used for "simulating" the migration and grabbing
		// the SQL queries that would fire if the migration were to be run against
		// a database for real, which is helpful for double checking migrations.
		$pretend = $this->input->getOption('pretend');

		$this->migrator->run($path);

		// Once the migrator has run we will grab the note output and send it out to
		// the console screen, since the migrator itself functions without having
		// any instances of the OutputInterface contract passed into the class.
		foreach ($this->migrator->getNotes() as $note)
		{
			$this->output->writeln($note);
		}
	}

}

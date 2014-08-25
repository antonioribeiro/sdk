<?php

namespace PragmaRX\Sdk\Core\Migrations;

use Illuminate\Database\Console\Migrations\RollbackCommand as IlluminateRollbackCommand;

use App;
use File;

class RollbackCommand extends IlluminateRollbackCommand {

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		if ( ! $this->confirmToProceed()) return;

		$this->migrator->setConnection($this->input->getOption('database'));

		$pretend = $this->input->getOption('pretend');

		$this->requireServiceMigrations();

		$this->migrator->rollback($pretend);

		// Once the migrator has run we will grab the note output and send it out to
		// the console screen, since the migrator itself functions without having
		// any instances of the OutputInterface contract passed into the class.
		foreach ($this->migrator->getNotes() as $note)
		{
			$this->output->writeln($note);
		}
	}

	private function requireServiceMigrations()
	{
		$services = App::make('config')->get('pragmarx/sdk::services');

		$paths = [];

		foreach ($services as $service)
		{
			foreach($this->getMigrations($service) as $migration)
			{
				require $migration;
			}
		}

		return $paths;
	}

	private function getMigrations($service)
	{
		foreach(File::allDirectories(__DIR__ . "/../../$service") as $directory)
		{
			if ($directory->getFileName() == 'migrations')
			{
				return File::glob($directory->getPathName().'/*_*.php');
			}
		}

		return [];
	}

}

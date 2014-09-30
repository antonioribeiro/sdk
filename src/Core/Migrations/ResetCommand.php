<?php

namespace PragmaRX\Sdk\Core\Migrations;

use Illuminate\Database\Console\Migrations\ResetCommand as IlluminateResetCommand;

class ResetCommand extends IlluminateResetCommand {

	use MigratableTrait;

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

		while (true)
		{
			$count = $this->migrator->rollback($pretend);

			// Once the migrator has run we will grab the note output and send it out to
			// the console screen, since the migrator itself functions without having
			// any instances of the OutputInterface contract passed into the class.
			foreach ($this->migrator->getNotes() as $note)
			{
				$this->output->writeln($note);
			}

			if ($count == 0) break;
		}

		$this->cleanTemporaryDirectory();
	}

}

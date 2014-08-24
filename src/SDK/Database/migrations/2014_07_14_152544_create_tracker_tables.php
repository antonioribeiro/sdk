<?php

use PragmaRX\Support\Migration;

use PragmaRX\Tracker\Vendor\Laravel\Facade as Tracker;

class CreateTrackerTables extends Migration {

	/**
	 * Run the migrations via migrator.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Tracker::getMigrator()->up();
	}

	/**
	 * Reverse the migrations via migrator.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Tracker::getMigrator()->down();
	}

}

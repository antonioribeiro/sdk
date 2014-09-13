<?php

use PragmaRX\Support\Migration;

use PragmaRX\Firewall\Vendor\Laravel\Facade as Firewall;

class CreateFirewallTables extends Migration {

	/**
	 * Run the migrations via migrator.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Firewall::getMigrator()->up();
	}

	/**
	 * Reverse the migrations via migrator.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Firewall::getMigrator()->down();
	}

}

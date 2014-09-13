<?php

use PragmaRX\Support\Migration;

class MigrateFirewall extends Migration {

	protected $tables = array(
		'firewall',
	);

	protected function migrateUp()
	{
		$this->builder->create(
			'firewall',
			function ($table)
			{
				$table->increments('id');

				$table->string('ip_address', 39)->unique()->index();

				$table->boolean('whitelisted')->default(false); /// default is blacklist

				$table->timestamps();
			}
		);
	}

	protected function migrateDown()
	{
		$this->dropAllTables();
	}
}

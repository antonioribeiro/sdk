<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDirectoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('directories', function(Blueprint $table)
		{
			$table->uuid('id')->primary();
			$table->string('host', 1024)->default('localhost');
			$table->string('path', 1024)->index();
			$table->string('relative_path', 1024)->index();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('directories');
	}

}

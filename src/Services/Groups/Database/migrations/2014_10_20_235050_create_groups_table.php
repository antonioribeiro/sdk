<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('groups', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('name')->index();

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
		Schema::drop('groups');
	}

}

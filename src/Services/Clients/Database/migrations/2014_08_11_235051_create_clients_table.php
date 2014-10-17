<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('clients', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('provider_id', 64);
			$table->string('first_name');
			$table->string('last_name');
			$table->text('notes')->nullable();

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
		Schema::drop('clients');
	}

}

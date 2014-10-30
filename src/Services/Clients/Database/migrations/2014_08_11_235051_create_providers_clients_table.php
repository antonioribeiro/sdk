<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProvidersClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('providers_clients', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();

			$table->string('provider_id', 64)->index();

			$table->string('client_id', 64)->index();

			$table->string('color', 64)->default('#a30f0f');

			$table->date('birthdate')->nullable();

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
		Schema::drop('providers_clients');
	}

}

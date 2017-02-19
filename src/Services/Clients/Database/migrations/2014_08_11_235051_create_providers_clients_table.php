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
			$table->uuid('id')->primary();

			$table->uuid('provider_id')->index();

			$table->uuid('client_id')->index();

			$table->string('color', 64)->default(Config::get('app.event_color'));

			$table->date('birthdate')->nullable();

            $table->text('notes')->nullable();

			$table->timestamps();
		});

		Schema::table('providers_clients', function(Blueprint $table)
		{
			$table->foreign('provider_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('providers_clients', function(Blueprint $table)
		{
			$table->foreign('client_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');
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

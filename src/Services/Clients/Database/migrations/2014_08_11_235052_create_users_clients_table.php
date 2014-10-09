<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('users_clients', function(Blueprint $table)
		{
			$table->string('user_id', 64)->unique()->index();
			$table->string('client_id', 64)->unique()->index();

			$table->timestamps();
		});

		Schema::table('users_clients', function(Blueprint $table)
		{
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('users_clients', function(Blueprint $table)
		{
			$table->foreign('client_id')
				->references('id')
				->on('clients')
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
		Schema::drop('users_clients');
	}

}

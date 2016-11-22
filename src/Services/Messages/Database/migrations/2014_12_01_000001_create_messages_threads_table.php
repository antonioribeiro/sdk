<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesThreadsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('messages_threads', function(Blueprint $table)
		{
			$table->uuid('id')->primary();

			$table->uuid('owner_id')->index();

			$table->string('subject');

			$table->timestamps();
		});

		Schema::table('messages_threads', function(Blueprint $table)
		{
			$table->foreign('owner_id')
					->references('id')
					->on('users')
					->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('messages_threads');
	}

}

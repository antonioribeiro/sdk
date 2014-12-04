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
			$table->string('id', 64)->primary();

			$table->string('owner_id', 64)->index();

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

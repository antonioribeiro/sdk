<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesParticipantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('messages_participants', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();

			$table->string('thread_id', 64)->index();

			$table->string('user_id', 64)->index();

			$table->string('folder_id', 64)->index()->nullable();

			$table->timestamp('last_read')->nullable();

			$table->timestamps();
		});

		Schema::table('messages_participants', function(Blueprint $table)
		{
			$table->foreign('thread_id')
					->references('id')
					->on('messages_threads')
					->onDelete('cascade')
					->onUpdate('cascade');
		});

		Schema::table('messages_participants', function(Blueprint $table)
		{
			$table->foreign('user_id')
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
		Schema::drop('messages_participants');
	}

}

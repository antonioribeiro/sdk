<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('messages_messages', function(Blueprint $table)
		{
			$table->uuid('id')->primary();

			$table->uuid('thread_id')->index();

            $table->uuid('sender_id')->index();

			$table->uuid('answering_message_id')->index()->nullable();

            $table->text('body');

			$table->softDeletes();

            $table->timestamps();
		});

		Schema::table('messages_messages', function(Blueprint $table)
		{
			$table->foreign('thread_id')
					->references('id')
					->on('messages_threads')
					->onDelete('cascade')
					->onUpdate('cascade');
		});

		Schema::table('messages_messages', function(Blueprint $table)
		{
			$table->foreign('answering_message_id')
					->references('id')
					->on('messages_messages')
					->onDelete('cascade')
					->onUpdate('cascade');
		});

		Schema::table('messages_messages', function(Blueprint $table)
		{
			$table->foreign('sender_id')
					->references('id')
					->on('messages_participants')
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
		Schema::drop('messages_messages');
	}

}

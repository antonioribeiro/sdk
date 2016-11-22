<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesAttachmentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('messages_attachments', function(Blueprint $table)
		{
			$table->uuid('id')->primary();

			$table->uuid('message_id')->index();

			$table->uuid('user_file_id')->index();

			$table->timestamps();
		});

		Schema::table('messages_attachments', function(Blueprint $table)
		{
			$table->foreign('message_id')
					->references('id')
					->on('messages_messages')
					->onUpdate('cascade')
					->onDelete('cascade');
		});

		Schema::table('messages_attachments', function(Blueprint $table)
		{
			$table->foreign('user_file_id')
					->references('id')
					->on('users_files')
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
		Schema::drop('messages_attachments');
	}

}

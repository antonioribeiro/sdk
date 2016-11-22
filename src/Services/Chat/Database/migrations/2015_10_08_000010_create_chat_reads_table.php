<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatReadsTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_reads', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('chat_business_client_talker_id')->index();
			$table->uuid('chat_id')->index();
			$table->bigInteger('last_read_message_serial');

			$table->timestamps();
		});

		Schema::table('chat_reads', function(Blueprint $table)
		{
			$table->foreign('chat_id')
				->references('id')
				->on('chats')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('chat_reads', function(Blueprint $table)
		{
			$table->foreign('chat_business_client_talker_id')
				->references('id')
				->on('chat_business_client_talkers')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	public function migrateDown()
	{
		Schema::drop('chat_reads');
	}
}

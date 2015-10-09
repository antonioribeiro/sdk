<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatMessagesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_messages', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('chat_id', 64);
			$table->text('message');

			$table->timestamps();
		});

		Schema::table('chat_messages', function(Blueprint $table)
		{
			$table->foreign('chat_id')
					->references('id')
					->on('chats')
					->onUpdate('cascade')
					->onDelete('cascade');
		});

		Schema::table('chat_messages', function(Blueprint $table)
		{
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	public function migrateDown()
	{
		Schema::drop('chat_messages');
	}
}

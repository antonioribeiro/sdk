<?php

use \DB;
use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatMessagesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_messages', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('chat_id', 64)->index();
			$table->string('chat_business_client_talker_id', 64)->index();
			$table->text('message');
			$table->string('chat_script_id', 64)->index();

			$table->timestamps();
		});

		DB::unprepared('alter table chat_messages add serial bigserial;');

		Schema::table('chat_messages', function(Blueprint $table)
		{
			$table->index('serial');
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
			$table->foreign('chat_business_client_talker_id')
				->references('id')
				->on('chat_business_client_talkers')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('chat_messages', function(Blueprint $table)
		{
			$table->foreign('chat_script_id')
				->references('id')
				->on('chat_scripts')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	public function migrateDown()
	{
		Schema::drop('chat_messages');
	}
}

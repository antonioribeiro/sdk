<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatMessagesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_messages', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('chat_id')->index();
			$table->uuid('chat_business_client_talker_id')->index();
			$table->string('talker_ip_address');
			$table->text('message');
			$table->uuid('chat_script_id')->nullable()->index();

			$table->timestamps();
		});

		\DB::unprepared('alter table chat_messages add serial bigserial;');

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

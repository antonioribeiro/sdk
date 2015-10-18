<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatsTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chats', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('chat_business_client_service_id', 64)->index();

			$table->string('owner_id', 64)->index();

			$table->string('responder_id', 64)->index()->nullable();

			$table->timestamp('opened_at')->index()->nullable();
			$table->timestamp('last_message_at')->index()->nullable();
			$table->timestamp('closed_at')->index()->nullable();

			$table->timestamps();
		});

		Schema::table('chats', function(Blueprint $table)
		{
			$table->foreign('chat_business_client_service_id')
				->references('id')
				->on('chat_business_client_services')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('chats', function(Blueprint $table)
		{
			$table->foreign('owner_id')
				->references('id')
				->on('chat_business_client_talkers')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('chats', function(Blueprint $table)
		{
			$table->foreign('responder_id')
				->references('id')
				->on('chat_business_client_talkers')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	public function migrateDown()
	{
		Schema::drop('chats');
	}
}

<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatsTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chats', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('chat_business_client_service_id')->index();

			$table->uuid('owner_id')->index();
			$table->string('owner_ip_address');

			$table->uuid('responder_id')->index()->nullable();

			$table->timestamp('opened_at')->index()->nullable();
			$table->timestamp('last_message_at')->index()->nullable();
			$table->timestamp('closed_at')->index()->nullable();

            $table->string('layout')->default('master');

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

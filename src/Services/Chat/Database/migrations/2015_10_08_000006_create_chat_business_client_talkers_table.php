<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatBusinessClientTalkersTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_business_client_talkers', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('chat_business_client_id', 64);
			$table->string('user_id', 64)->index()->nullable();
			$table->string('phone_id', 64)->index()->nullable();

			$table->timestamps();
		});

		Schema::table('chat_business_client_talkers', function(Blueprint $table)
		{
			$table->foreign('chat_business_client_id')
				->references('id')
				->on('chat_business_clients')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('chat_business_client_talkers', function(Blueprint $table)
		{
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('chat_business_client_talkers', function(Blueprint $table)
		{
			$table->foreign('phone_id')
				->references('id')
				->on('chat_phones')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	public function migrateDown()
	{
		Schema::drop('chat_business_client_talkers');
	}
}

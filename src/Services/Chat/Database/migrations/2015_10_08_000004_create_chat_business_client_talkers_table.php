<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatBusinessClientTalkersTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_business_client_talkers', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('business_client_id');
			$table->uuid('user_id')->index()->nullable();
			$table->uuid('phone_id')->index()->nullable();

			$table->timestamps();
		});

		Schema::table('chat_business_client_talkers', function(Blueprint $table)
		{
			$table->foreign('business_client_id')
				->references('id')
				->on('business_clients')
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

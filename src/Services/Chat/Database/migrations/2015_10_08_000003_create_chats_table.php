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

			$table->string('chat_customer_id', 64);
			$table->string('user_id', 64);

			$table->timestamps();
		});

		Schema::table('chats', function(Blueprint $table)
		{
			$table->foreign('chat_customer_id')
				->references('id')
				->on('chat_clients')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('chats', function(Blueprint $table)
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
		Schema::drop('chats');
	}
}

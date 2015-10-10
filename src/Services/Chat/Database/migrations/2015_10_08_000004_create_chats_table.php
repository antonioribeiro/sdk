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

			$table->string('chat_room_id', 64);

			$table->string('owner_id', 64);

			$table->string('responder_id', 64)->nullable();

			$table->timestamp('started_at')->nullable();
			$table->timestamp('finished_at')->nullable();

			$table->timestamps();
		});

		Schema::table('chats', function(Blueprint $table)
		{
			$table->foreign('chat_room_id')
				->references('id')
				->on('chat_rooms')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('chats', function(Blueprint $table)
		{
			$table->foreign('owner_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('chats', function(Blueprint $table)
		{
			$table->foreign('responder_id')
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

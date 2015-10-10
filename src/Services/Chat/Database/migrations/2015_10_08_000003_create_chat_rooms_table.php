<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatRoomsTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_rooms', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('chat_customer_id', 64);
			$table->string('name');

			$table->timestamps();
		});

		Schema::table('chat_rooms', function(Blueprint $table)
		{
			$table->foreign('chat_customer_id')
				->references('id')
				->on('chat_clients')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	public function migrateDown()
	{
		Schema::drop('chat_rooms');
	}
}

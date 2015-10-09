<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatClientsTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_clients', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('name');

			$table->timestamps();
		});
	}

	public function migrateDown()
	{
		Schema::drop('chat_clients');
	}
}

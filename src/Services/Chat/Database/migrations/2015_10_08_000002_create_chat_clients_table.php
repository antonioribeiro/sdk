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

			$table->string('chat_business_id', 64);
			$table->string('name');

			$table->timestamps();
		});

		Schema::table('chat_clients', function(Blueprint $table)
		{
			$table->foreign('chat_business_id')
				->references('id')
				->on('chat_businesses')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	public function migrateDown()
	{
		Schema::drop('chat_clients');
	}
}

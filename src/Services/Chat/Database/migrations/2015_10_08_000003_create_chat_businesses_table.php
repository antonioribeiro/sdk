<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatBusinessesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_businesses', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('name')->index();

			$table->timestamps();
		});
	}

	public function migrateDown()
	{
		Schema::drop('chat_businesses');
	}
}

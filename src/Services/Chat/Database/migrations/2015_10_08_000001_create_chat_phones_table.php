<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatPhonesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_phones', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->string('number')->index();

			$table->timestamps();
		});
	}

	public function migrateDown()
	{
		Schema::drop('chat_phones');
	}
}

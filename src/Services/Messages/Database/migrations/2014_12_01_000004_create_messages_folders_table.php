<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesFoldersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('messages_folders', function(Blueprint $table)
		{
			$table->uuid('id')->primary();

			$table->uuid('user_id')->index();

			$table->string('name');

			$table->timestamps();
		});

		Schema::table('messages_folders', function(Blueprint $table)
		{
			$table->foreign('user_id')
					->references('id')
					->on('users')
					->onUpdate('cascade')
					->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('messages_folders');
	}

}

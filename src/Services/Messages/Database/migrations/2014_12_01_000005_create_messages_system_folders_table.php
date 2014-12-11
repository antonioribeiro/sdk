<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesSystemFoldersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('messages_system_folders', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();

			$table->string('name');
		});

		DB::table('messages_system_folders')->insert(
			array('id' => 'all', 'name' => 'All')
		);

		DB::table('messages_system_folders')->insert(
			array('id' => 'inbox', 'name' => 'Inbox')
		);

		DB::table('messages_system_folders')->insert(
			array('id' => 'sent', 'name' => 'Sent')
		);

		DB::table('messages_system_folders')->insert(
			array('id' => 'archive', 'name' => 'Archive')
		);
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('messages_system_folders');
	}

}

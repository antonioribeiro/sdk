<?php

use PragmaRX\Sdk\Services\Messages\Data\Entities\SystemFolder;
use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesSystemFoldersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('messages_system_folders', function(Blueprint $table)
		{
			$table->uuid('id')->primary();

            $table->string('slug');

			$table->string('name');

			$table->timestamps();
		});

		SystemFolder::create(
			array('slug' => 'all', 'name' => 'All')
		);

		SystemFolder::create(
			array('slug' => 'inbox', 'name' => 'Inbox')
		);

		SystemFolder::create(
			array('slug' => 'sent', 'name' => 'Sent')
		);

		SystemFolder::create(
			array('slug' => 'archive', 'name' => 'Archive')
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

<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTelegramFilesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('telegram_files', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

            $table->string('telegram_file_id')->unique()->index();
            $table->uuid('file_name_id')->nullable()->index();
            $table->integer('file_size')->nullable()->unsigned();
            $table->string('file_path')->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('telegram_files');
	}
}

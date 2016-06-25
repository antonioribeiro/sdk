<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacebookMessengerFilesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('facebook_messenger_files', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

            $table->string('facebook_messenger_file_id')->unique()->index();
            $table->string('file_name_id', 64)->nullable()->index();
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
		Schema::drop('facebook_messenger_files');
	}
}

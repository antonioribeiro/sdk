<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacebookMessengerPhotosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('facebook_messenger_photos', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

            $table->string('facebook_messenger_file_id')->unique()->index();
            $table->string('file_name_id', 64)->nullable()->index();
            $table->integer('width');
            $table->integer('height');
            $table->integer('file_size')->nullable()->unsigned();

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
		Schema::drop('facebook_messenger_photos');
	}
}

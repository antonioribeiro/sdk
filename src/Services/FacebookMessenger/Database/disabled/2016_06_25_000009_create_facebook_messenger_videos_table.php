<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacebookMessengerVideosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('facebook_messenger_videos', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

            $table->string('facebook_messenger_file_id')->unique()->index();
            $table->uuid('file_name_id')->nullable()->index();
            $table->integer('width');
            $table->integer('height');
            $table->integer('duration');
            $table->uuid('thumb_id')->nullable();
            $table->string('mime_type')->nullable();
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
		Schema::drop('facebook_messenger_videos');
	}
}

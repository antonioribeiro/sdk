<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTelegramVideosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('telegram_videos', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

            $table->string('telegram_file_id')->unique()->index();
            $table->integer('width');
            $table->integer('height');
            $table->integer('duration');
            $table->string('thumb_id', 64)->nullable();
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
		Schema::drop('telegram_videos');
	}
}

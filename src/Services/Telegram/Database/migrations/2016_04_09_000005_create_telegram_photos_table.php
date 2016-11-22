<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTelegramPhotosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('telegram_photos', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

            $table->string('telegram_file_id')->unique()->index();
            $table->uuid('file_name_id')->nullable()->index();
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
		Schema::drop('telegram_photos');
	}
}

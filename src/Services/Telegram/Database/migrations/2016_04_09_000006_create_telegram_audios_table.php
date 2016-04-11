<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTelegramAudiosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('telegram_audios', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

            $table->bigInteger('telegram_file_id', false)->unsigned()->unique()->index();
            $table->integer('duration')->nullable();
            $table->string('performer')->nullable();
            $table->string('title')->nullable();
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
		Schema::drop('telegram_audios');
	}
}

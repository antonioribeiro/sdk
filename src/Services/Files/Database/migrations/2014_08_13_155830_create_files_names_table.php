<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilesNamesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('files_names', function(Blueprint $table)
		{
			$table->uuid('id')->primary();
			$table->uuid('file_id')->index();
			$table->string('name', 1024)->index();
			$table->timestamps();
		});

		Schema::table('files_names', function(Blueprint $table)
		{
			$table->foreign('file_id')
					->references('id')
					->on('files')
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
		Schema::drop('files_names');
	}

}

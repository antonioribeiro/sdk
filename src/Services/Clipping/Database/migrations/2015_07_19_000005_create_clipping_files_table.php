<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClippingFilesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('clipping_files', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('clipping_id', 64)->nullable();

			$table->boolean('is_main')->default(false);

			$table->boolean('is_snapshot')->default(false);

			$table->string('file_name_id', 64)->nullable();

			$table->string('file_type_id', 64);

			$table->string('url', 1024);

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
		Schema::drop('clipping_files');
	}
}

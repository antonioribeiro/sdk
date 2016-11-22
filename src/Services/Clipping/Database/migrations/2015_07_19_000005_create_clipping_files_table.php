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
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('clipping_id')->nullable();

			$table->boolean('is_main')->default(false);

			$table->boolean('is_snapshot')->default(false);

			$table->boolean('is_video')->default(false);

			$table->uuid('file_name_id')->nullable();

			$table->uuid('file_type_id');

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

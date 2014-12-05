<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('files', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();
			$table->string('directory_id', 64)->index();
			$table->string('deep_path')->nullable();
			$table->string('size')->bigInt();
			$table->string('hash')->index();
			$table->string('extension')->index();
			$table->boolean('image')->default(true);
			$table->timestamps();
		});

		Schema::table('files', function(Blueprint $table)
		{
			$table->foreign('directory_id')
					->references('id')
					->on('directories')
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
		Schema::drop('files');
	}

}

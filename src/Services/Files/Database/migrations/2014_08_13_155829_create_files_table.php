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
			$table->increments('id');
			$table->integer('root_path_id')->unsigned()->index();
			$table->string('name')->index();
			$table->string('hash')->index();
			$table->string('extension')->index();
			$table->boolean('image')->default(true);
			$table->timestamps();
		});

		Schema::table('files', function(Blueprint $table)
		{
			$table->foreign('root_path_id')
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

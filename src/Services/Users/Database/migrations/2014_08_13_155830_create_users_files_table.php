<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('users_files', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('file_name_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
			$table->timestamps();
		});

		Schema::table('users_files', function(Blueprint $table)
		{
			$table->foreign('file_name_id')
					->references('id')
					->on('files_names')
					->onUpdate('cascade')
					->onDelete('cascade');
		});

		Schema::table('users_files', function(Blueprint $table)
		{
			$table->foreign('user_id')
				->references('id')
				->on('users')
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
		Schema::drop('users_files');
	}

}

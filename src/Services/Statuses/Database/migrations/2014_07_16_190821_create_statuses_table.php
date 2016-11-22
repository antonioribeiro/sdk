<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('statuses', function(Blueprint $table)
		{
			$table->uuid('id')->primary();
			$table->uuid('user_id')->index();
			$table->text('body');
			$table->timestamps();
		});

		Schema::table('statuses', function(Blueprint $table)
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
		Schema::drop('statuses');
	}

}

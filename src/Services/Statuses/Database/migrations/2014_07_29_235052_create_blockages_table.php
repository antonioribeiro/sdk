<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlockagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('blockages', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('blocker_id')->unsigned()->index();
			$table->integer('blocked_id')->unsigned()->index();

			$table->timestamps();
		});

		Schema::table('blockages', function(Blueprint $table)
		{
			$table->foreign('blocker_id')
					->references('id')
					->on('users')
					->onUpdate('cascade')
					->onDelete('cascade');
		});

		Schema::table('blockages', function(Blueprint $table)
		{
			$table->foreign('blocked_id')
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
		Schema::drop('blockages');
	}

}

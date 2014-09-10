<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProfilesVisitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('profiles_visits', function(Blueprint $table)
		{
			$table->string('visitor_id', 64)->index();
			$table->string('visited_id', 64)->index();
			$table->string('session_id')->index();

			$table->timestamps();
		});

		Schema::table('profiles_visits', function(Blueprint $table)
		{
			$table->foreign('visitor_id')
					->references('id')
					->on('users')
					->onUpdate('cascade')
					->onDelete('cascade');
		});

		Schema::table('profiles_visits', function(Blueprint $table)
		{
			$table->foreign('visited_id')
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
		Schema::drop('profiles_visits');
	}

}

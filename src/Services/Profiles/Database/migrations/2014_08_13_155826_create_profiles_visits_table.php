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
			$table->uuid('visitor_id')->index();
			$table->uuid('visited_id')->index();
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

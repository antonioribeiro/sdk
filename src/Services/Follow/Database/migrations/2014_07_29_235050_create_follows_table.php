<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFollowsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('follows', function(Blueprint $table)
		{
			$table->uuid('follower_id')->index();
			$table->uuid('followed_id')->index();

			$table->timestamps();
		});

		Schema::table('follows', function(Blueprint $table)
		{
			$table->foreign('follower_id')
					->references('id')
					->on('users')
					->onUpdate('cascade')
					->onDelete('cascade');
		});

		Schema::table('follows', function(Blueprint $table)
		{
			$table->foreign('followed_id')
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
		Schema::drop('follows');
	}

}

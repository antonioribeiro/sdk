<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('username')->index()->nullable();
			$table->uuid('avatar_id')->nullable();
		});

		DB::statement(
			DB::raw("update users set username=email where username is null;")
		);

		Schema::table('users', function(Blueprint $table)
		{
			$table->unique('username');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		$this->dropColumn('users', 'username');
		$this->dropColumn('users', 'avatar_id');
	}

}

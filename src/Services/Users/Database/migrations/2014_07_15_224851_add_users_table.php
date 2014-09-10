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
			$table->string('avatar_id', 64)->nullable();
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

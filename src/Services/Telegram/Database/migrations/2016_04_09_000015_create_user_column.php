<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserColumn extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('telegram_user_id', 64)->nullable()->index();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
        Schema::table('users', function(Blueprint $table)
        {
            $table->dropColumn('telegram_user_id');
        });
	}
}

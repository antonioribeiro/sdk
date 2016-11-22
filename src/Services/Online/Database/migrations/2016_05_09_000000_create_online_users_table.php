<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOnlineUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('online_users', function(Blueprint $table)
		{
            $table->uuid('id')->primary();

			$table->uuid('user_id')->index();
			$table->timestamp('last_seen_at')->index();
			$table->boolean('online')->default(true)->index();

            $table->timestamps();
		});
    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('online_users');
	}
}

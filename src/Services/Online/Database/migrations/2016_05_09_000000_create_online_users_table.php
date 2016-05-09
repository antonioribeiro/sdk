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
            $table->string('id', 64)->primary();

			$table->string('user_id', 64)->index();
			$table->timestamp('last_seen_at')->index();
			$table->boolean('online')->default(true)->index();

            $table->timestamps();
		});

        $this->removeLastSeenFromUsersTable();
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

    private function removeLastSeenFromUsersTable()
    {
        $columns = Schema::getColumnListing('users');

        if (array_search('last_seen_at', $columns))
        {
            // Remove column created on a different Migration
            // not needed anymore
            Schema::table('users', function (Blueprint $table)
            {
                $table->dropColumn('last_seen_at');
            });
        }
    }
}

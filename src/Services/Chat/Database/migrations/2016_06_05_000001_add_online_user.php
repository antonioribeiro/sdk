<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddOnlineUser extends Migration
{
	public function migrateUp()
	{
		Schema::table('online_users', function(Blueprint $table)
		{
			$table->boolean('online_on_chat', 64)->default(false)->index();
            $table->timestamp('last_seen_on_chat', 64)->nullable()->index();
		});
	}

	public function migrateDown()
	{
        Schema::table('online_users', function(Blueprint $table)
        {
            $table->dropColumn('online_on_chat');
            $table->dropColumn('last_seen_on_chat');
        });
	}
}

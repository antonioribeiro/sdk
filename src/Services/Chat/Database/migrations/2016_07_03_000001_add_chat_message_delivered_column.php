<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddChatMessageDeliveredColumn extends Migration
{
	public function migrateUp()
	{
		Schema::table('chat_messages', function(Blueprint $table)
		{
			$table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
		});
	}

	public function migrateDown()
	{
        Schema::table('chat_messages', function(Blueprint $table)
        {
            $table->dropColumn('delivered_at');
            $table->dropColumn('read_at');
        });
	}
}

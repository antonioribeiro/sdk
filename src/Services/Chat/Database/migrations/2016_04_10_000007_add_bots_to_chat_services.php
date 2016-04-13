<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddBotsToChatServices extends Migration
{
	public function migrateUp()
	{
		Schema::table('chat_business_client_services', function(Blueprint $table)
		{
			$table->string('bot_name')->nullable();
            $table->string('bot_token')->nullable();
            $table->string('bot_webhook_url')->nullable();
		});
	}

	public function migrateDown()
	{
        Schema::table('chat_business_client_services', function(Blueprint $table)
        {
            $table->dropColumn('bot_name');
            $table->dropColumn('bot_token');
            $table->dropColumn('bot_webhook_url');
        });
	}
}

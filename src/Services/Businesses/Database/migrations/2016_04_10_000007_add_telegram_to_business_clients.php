<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTelegramToBusinessClients extends Migration
{
	public function migrateUp()
	{
		Schema::table('business_clients', function(Blueprint $table)
		{
			$table->string('telegram_bot_name')->nullable();
            $table->string('telegram_bot_token')->nullable();
            $table->string('telegram_bot_webhook_url')->nullable();
		});
	}

	public function migrateDown()
	{
        Schema::table('business_clients', function(Blueprint $table)
        {
            $table->dropColumn('telegram_bot_name');
            $table->dropColumn('telegram_bot_token');
            $table->dropColumn('telegram_bot_webhook_url');
        });
	}
}

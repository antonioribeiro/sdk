<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFacebookAppToChatServices extends Migration
{
	public function migrateUp()
	{
		Schema::table('chat_business_client_services', function(Blueprint $table)
		{
			$table->string('app_id')->nullable();
            $table->string('app_secret')->nullable();
		});
	}

	public function migrateDown()
	{
        Schema::table('chat_business_client_services', function(Blueprint $table)
        {
            $table->dropColumn('app_id');
            $table->dropColumn('app_secret');
        });
	}
}

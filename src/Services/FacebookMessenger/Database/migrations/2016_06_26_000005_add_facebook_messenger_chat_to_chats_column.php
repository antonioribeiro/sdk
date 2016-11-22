<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddFacebookMessengerChatToChatsColumn extends Migration
{
	public function migrateUp()
	{
		Schema::table('chats', function(Blueprint $table)
		{
			$table->uuid('facebook_messenger_chat_id')->nullable()->index();
		});

        Schema::table('chat_messages', function(Blueprint $table)
        {
            $table->uuid('facebook_messenger_message_id')->nullable()->index();
        });
	}

	public function migrateDown()
	{
        Schema::table('chats', function(Blueprint $table)
        {
            $table->dropColumn('facebook_messenger_chat_id');
        });

        Schema::table('chat_messages', function(Blueprint $table)
        {
            $table->dropColumn('facebook_messenger_message_id');
        });
	}
}

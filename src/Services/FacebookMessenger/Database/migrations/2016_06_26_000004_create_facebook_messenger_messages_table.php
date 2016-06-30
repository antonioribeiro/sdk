<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacebookMessengerMessagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('facebook_messenger_messages', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

            $table->string('chat_id', 64);
			$table->string('mid')->index();
            $table->bigInteger('seq');
			$table->string('sender_id', 64);
            $table->string('recipient_id', 64);
            $table->bigInteger('time');
            $table->timestamp('timestamp');
            $table->string('text', 4097)->nullable();
            $table->json('attachments')->nullable();

			$table->timestamps();
		});

        Schema::table('facebook_messenger_messages', function(Blueprint $table)
        {
            $table->foreign('chat_id')
                  ->references('id')
                  ->on('facebook_messenger_chats')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('facebook_messenger_messages');
	}
}

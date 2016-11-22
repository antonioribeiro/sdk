<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTelegramMessagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('telegram_messages', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->bigInteger('telegram_message_id', false)->unsigned()->index();
            $table->uuid('chat_id');
			$table->uuid('from_id');
            $table->integer('date');
            $table->timestamp('timestamp');
            $table->uuid('forward_from_id')->nullable();
            $table->integer('forward_date')->nullable();
            $table->uuid('reply_to_message_id')->nullable();
            $table->string('text', 4097)->nullable();
            $table->uuid('audio_id')->nullable();
            $table->uuid('document_id')->nullable();
            $table->uuid('photo')->nullable();
            $table->uuid('sticker_id')->nullable();
            $table->uuid('video_id')->nullable();
            $table->uuid('voice_id')->nullable();
            $table->uuid('venue_id')->nullable();
            $table->string('caption')->nullable();
            $table->uuid('contact_id')->nullable();
            $table->uuid('location_id')->nullable();
            $table->uuid('new_chat_participant_id')->nullable();
            $table->uuid('left_chat_participant_id')->nullable();
            $table->string('new_chat_title')->nullable();
            $table->uuid('new_chat_photo')->nullable();
            $table->uuid('entities')->nullable();
            $table->boolean('delete_chat_photo')->default(false);
            $table->boolean('group_chat_created')->default(false);
            $table->boolean('supergroup_chat_created')->default(false);
            $table->boolean('channel_chat_created')->default(false);
            $table->uuid('migrate_to_chat_id')->nullable();
            $table->uuid('migrate_from_chat_id')->nullable();

			$table->timestamps();
		});

        Schema::table('telegram_messages', function(Blueprint $table)
        {
            $table->foreign('chat_id')
                  ->references('id')
                  ->on('telegram_chats')
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
		Schema::drop('telegram_messages');
	}
}

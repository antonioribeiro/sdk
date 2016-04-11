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
			$table->string('id', 64)->unique()->primary()->index();

			$table->bigInteger('telegram_message_id', false)->unsigned()->unique()->index();
            $table->string('chat_id', 64);
			$table->string('from_id', 64);
            $table->integer('date');
            $table->string('forward_from_id', 64)->nullable();
            $table->integer('forward_date')->nullable();
            $table->string('reply_to_message_id', 64)->nullable();
            $table->string('text', 4097)->nullable();
            $table->string('audio_id', 64)->nullable();
            $table->string('document_id', 64)->nullable();
            $table->json('photo')->nullable();
            $table->string('sticker_id', 64)->nullable();
            $table->string('video_id', 64)->nullable();
            $table->string('voice_id', 64)->nullable();
            $table->string('caption')->nullable();
            $table->string('contact_id', 64)->nullable();
            $table->string('location_id', 64)->nullable();
            $table->string('new_chat_participant_id', 64)->nullable();
            $table->string('left_chat_participant_id', 64)->nullable();
            $table->string('new_chat_title')->nullable();
            $table->json('new_chat_photo')->nullable();
            $table->boolean('delete_chat_photo')->default(false);
            $table->boolean('group_chat_created')->default(false);
            $table->boolean('supergroup_chat_created')->default(false);
            $table->boolean('channel_chat_created')->default(false);
            $table->string('migrate_to_chat_id', 64)->nullable();
            $table->string('migrate_from_chat_id', 64)->nullable();

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
		Schema::drop('telegram_messages');
	}
}

<?php

use PragmaRX\Sdk\Services\Messages\Data\Entities\SystemFolder;
use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessagesParticipantsTable extends Migration
{
    private function getInbox()
    {
        return SystemFolder::where('slug', 'inbox')->first();
    }

    /**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('messages_participants', function(Blueprint $table)
		{
		    $inbox = $this->getInbox();

			$table->uuid('id')->primary();

			$table->uuid('thread_id')->index();

			$table->uuid('user_id')->index();

			$table->uuid('folder_id')->index()->nullable()->default($inbox->id);

			$table->timestamp('last_read')->nullable();

			$table->timestamps();
		});

		Schema::table('messages_participants', function(Blueprint $table)
		{
			$table->foreign('thread_id')
					->references('id')
					->on('messages_threads')
					->onDelete('cascade')
					->onUpdate('cascade');
		});

		Schema::table('messages_participants', function(Blueprint $table)
		{
			$table->foreign('user_id')
					->references('id')
					->on('users')
					->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('messages_participants');
	}

}

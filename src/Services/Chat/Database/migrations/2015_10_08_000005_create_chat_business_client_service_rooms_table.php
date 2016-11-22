<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatBusinessClientServiceRoomsTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_business_client_service_rooms', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('chat_business_client_service_id');
			$table->boolean('allow_many_talkers')->default(false);
			$table->string('name')->index();

			$table->timestamps();
		});

		Schema::table('chat_business_client_service_rooms', function(Blueprint $table)
		{
			$table->foreign('chat_business_client_service_id')
				->references('id')
				->on('chat_business_client_services')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	public function migrateDown()
	{
		Schema::drop('chat_business_client_service_rooms');
	}
}

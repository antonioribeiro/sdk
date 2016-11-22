<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatBusinessClientServicesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_business_client_services', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('business_client_id');
			$table->uuid('chat_service_id');
			$table->string('description');

			$table->timestamps();
		});

		Schema::table('chat_business_client_services', function(Blueprint $table)
		{
			$table->foreign('business_client_id')
				->references('id')
				->on('business_clients')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('chat_business_client_services', function(Blueprint $table)
		{
			$table->foreign('chat_service_id')
				->references('id')
				->on('chat_services')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	public function migrateDown()
	{
		Schema::drop('chat_business_client_services');
	}
}

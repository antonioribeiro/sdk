<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatScriptsTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_scripts', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('business_client_id')->index();
			$table->uuid('chat_service_id')->index()->nullable();
			$table->uuid('chat_script_type_id')->index();
			$table->integer('order')->nullable();
			$table->string('name');
			$table->text('script');

			$table->timestamps();
		});

		Schema::table('chat_scripts', function(Blueprint $table)
		{
			$table->foreign('business_client_id')
				->references('id')
				->on('business_clients')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('chat_scripts', function(Blueprint $table)
		{
			$table->foreign('chat_service_id')
				->references('id')
				->on('chat_services')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('chat_scripts', function(Blueprint $table)
		{
			$table->foreign('chat_script_type_id')
				->references('id')
				->on('chat_script_types')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

	}

	public function migrateDown()
	{
		Schema::drop('chat_scripts');
	}
}

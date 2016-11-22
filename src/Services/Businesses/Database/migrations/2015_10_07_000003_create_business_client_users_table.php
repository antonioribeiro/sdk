<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessClientUsersTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('business_client_users', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('business_client_id');
			$table->uuid('user_id')->nullable();

			$table->timestamps();
		});

		Schema::table('business_client_users', function(Blueprint $table)
		{
			$table->foreign('business_client_id')
				->references('id')
				->on('business_clients')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('business_client_users', function(Blueprint $table)
		{
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	public function migrateDown()
	{
		Schema::drop('business_client_users');
	}
}

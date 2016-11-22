<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessClientUserRolesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('business_client_user_roles', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('business_client_user_id');
			$table->uuid('business_role_id');

			$table->timestamps();
		});

		Schema::table('business_client_user_roles', function(Blueprint $table)
		{
			$table->foreign('business_client_user_id')
				->references('id')
				->on('business_client_users')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('business_client_user_roles', function(Blueprint $table)
		{
			$table->foreign('business_role_id')
				->references('id')
				->on('business_roles')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	public function migrateDown()
	{
		Schema::drop('business_client_user_roles');
	}
}

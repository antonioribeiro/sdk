<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessClientUserRolesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('business_client_user_roles', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('business_client_id', 64);
			$table->string('user_id', 64);
			$table->string('business_role_id', 64);

			$table->timestamps();
		});

		Schema::table('business_client_user_roles', function(Blueprint $table)
		{
			$table->foreign('business_client_id')
				->references('id')
				->on('business_clients')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('business_client_user_roles', function(Blueprint $table)
		{
			$table->foreign('user_id')
				->references('id')
				->on('users')
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

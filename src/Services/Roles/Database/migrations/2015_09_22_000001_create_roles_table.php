<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('roles', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->string('name');
			$table->string('slug');
			$table->text('permission_list')->nullable();

			$table->timestamps();
		});

		// Permission Roles
		Schema::create('permissions_roles', function(Blueprint $table)
		{
			$table->uuid('permission_id')->index();
			$table->uuid('role_id')->index();

			$table->primary(['permission_id', 'role_id']);

			$table->timestamps();
		});

		Schema::table('permissions_roles', function(Blueprint $table)
		{
			$table->foreign('permission_id')
					->references('id')
					->on('permissions')
					->onUpdate('cascade')
					->onDelete('cascade');
		});

		Schema::table('permissions_roles', function(Blueprint $table)
		{
			$table->foreign('role_id')
				->references('id')
				->on('roles')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		// User Roles
		Schema::create('users_roles', function(Blueprint $table)
		{
			$table->uuid('user_id')->index();
			$table->uuid('role_id')->index();

			$table->primary(['user_id', 'role_id']);

			$table->timestamps();
		});

		Schema::table('users_roles', function(Blueprint $table)
		{
			$table->foreign('user_id')
				->references('id')
				->on('users')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('users_roles', function(Blueprint $table)
		{
			$table->foreign('role_id')
				->references('id')
				->on('roles')
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
		Schema::drop('users_roles');
		Schema::drop('permissions_roles');
		Schema::drop('roles');
	}
}

<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('roles', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('name');
			$table->string('slug');
			$table->text('permissions')->nullable();

			$table->timestamps();
		});

		Schema::create('permissions_roles', function(Blueprint $table)
		{
			$table->string('permission_id', 64)->index();
			$table->string('role_id', 64)->index();

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
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('permissions_roles');
		Schema::drop('roles');
	}

}

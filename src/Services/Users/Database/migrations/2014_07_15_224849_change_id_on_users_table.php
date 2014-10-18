<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class ChangeIdOnUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Drop Sentinel users and recreate it

		Schema::drop('users');
		Schema::drop('throttle');
		Schema::drop('role_users');
		Schema::drop('roles');
		Schema::drop('reminders');
		Schema::drop('persistences');
		Schema::drop('activations');

		Schema::create('users', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();

			$table->string('email')->unique()->index();
			$table->string('password');
			$table->text('permissions')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->boolean('is_account')->index()->default(false);

			$table->timestamps();
		});

		Schema::create('activations', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();

			$table->string('user_id', 64);
			$table->string('code');
			$table->boolean('completed')->default(0);
			$table->timestamp('completed_at')->nullable();

			$table->timestamps();
		});

		Schema::create('persistences', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();

			$table->string('user_id', 64);
			$table->string('code');

			$table->timestamps();
		});

		Schema::create('reminders', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();

			$table->string('user_id', 64);
			$table->string('code');
			$table->boolean('completed')->default(0);
			$table->timestamp('completed_at')->nullable();

			$table->timestamps();
		});

		Schema::create('roles', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();

			$table->string('slug');
			$table->string('name');
			$table->text('permissions')->nullable();

			$table->timestamps();
		});

		Schema::create('role_users', function(Blueprint $table)
		{
			$table->string('user_id', 64);
			$table->string('role_id', 64);

			$table->nullableTimestamps();
		});

		Schema::create('throttle', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();

			$table->string('user_id', 64);
			$table->string('type');
			$table->string('ip')->nullable();

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
		$tables = [
			'users',
			'throttle',
			'role_users',
			'roles',
			'reminders',
			'persistences',
			'activations',
		];

		foreach ($tables as $tableName)
		{
			$this->dropColumn($tableName, 'id');

			Schema::table($tableName, function(Blueprint $table)
			{
				$table->increments('id')->unique();
			});
		}

	}

}

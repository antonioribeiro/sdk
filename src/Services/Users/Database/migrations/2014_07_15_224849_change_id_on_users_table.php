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

		$this->drop('users');
		$this->drop('throttle');
		$this->drop('reminders');
		$this->drop('persistences');
		$this->drop('activations');

		Schema::create('users', function(Blueprint $table)
		{
			$table->uuid('id')->primary();

			$table->string('email')->unique()->index();
			$table->string('password');
			$table->text('permissions')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();

			$table->timestamps();
		});

		Schema::create('activations', function(Blueprint $table)
		{
			$table->uuid('id')->primary();

			$table->uuid('user_id');
			$table->string('code');
			$table->boolean('completed')->default(0);
			$table->timestamp('completed_at')->nullable();

			$table->timestamps();
		});

		Schema::create('persistences', function(Blueprint $table)
		{
			$table->uuid('id')->primary();

			$table->uuid('user_id');
			$table->string('code');

			$table->timestamps();
		});

		Schema::create('reminders', function(Blueprint $table)
		{
			$table->uuid('id')->primary();

			$table->uuid('user_id');
			$table->string('code');
			$table->boolean('completed')->default(0);
			$table->timestamp('completed_at')->nullable();

			$table->timestamps();
		});

		Schema::create('throttle', function(Blueprint $table)
		{
			$table->uuid('id')->primary();

			$table->uuid('user_id');
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
			'throttle',
			'reminders',
			'persistences',
			'activations',
		];

		foreach ($tables as $tableName)
		{
			$this->drop($tableName);
//
//			Schema::table($tableName, function(Blueprint $table)
//			{
//				$table->increments('id')->unique();
//			});
		}
	}

}

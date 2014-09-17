<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailChangesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('email_changes', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();
			$table->string('user_id', 64)->index();
			$table->string('email');
			$table->string('token')->index();
			$table->timestamp('old_confirmed_at')->nullable();
			$table->timestamp('new_confirmed_at')->nullable();
			$table->timestamps();
		});

		Schema::table('email_changes', function(Blueprint $table)
		{
			$table->foreign('user_id')
					->references('id')
					->on('users')
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
		Schema::drop('email_changes');
	}

}

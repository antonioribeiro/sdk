<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateConnectionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('connections', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('requestor_id')->index();
			$table->uuid('requested_id')->index();

			$table->boolean('authorized')->index()->default(false);
			$table->timestamp('authorized_at')->nullable();
			$table->timestamp('denied_at')->nullable();
			$table->timestamp('postponed_at')->nullable();

			$table->timestamps();
		});

		Schema::table('connections', function(Blueprint $table)
		{
			$table->foreign('requestor_id')
					->references('id')
					->on('users')
					->onUpdate('cascade')
					->onDelete('cascade');
		});

		Schema::table('connections', function(Blueprint $table)
		{
			$table->foreign('requested_id')
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
		Schema::drop('connections');
	}

}

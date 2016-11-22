<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActivationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		/// Check --- ChangeIdOnUsersTable -- Sentinel !!

//		Schema::create('activations', function(Blueprint $table)
//		{
//			$table->uuid('id')->unique()->primary()->index();
//
//			$table->uuid('user_id');
//			$table->string('code');
//			$table->boolean('completed')->default(0);
//			$table->timestamp('completed_at')->nullable();
//
//			$table->timestamps();
//		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
//		Schema::drop('activations');
	}

}

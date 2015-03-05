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
//			$table->string('id', 64)->unique()->primary()->index();
//
//			$table->string('user_id', 64);
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

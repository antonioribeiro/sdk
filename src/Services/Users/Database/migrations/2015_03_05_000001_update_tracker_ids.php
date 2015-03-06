<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class UpdateTrackerIds extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		$this->dropColumn('tracker_sessions', 'user_id');

		Schema::table('tracker_sessions', function(Blueprint $table)
		{
			$table->string('user_id', 64)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		// Ignore
	}

}

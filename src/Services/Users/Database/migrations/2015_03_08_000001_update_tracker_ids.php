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
		if ($this->tableExists('tracker_sessions'))
		{
			$this->dropColumn('tracker_sessions', 'user_id');

			Schema::table('tracker_sessions', function(Blueprint $table)
			{
				$table->uuid('user_id')->nullable();
			});
		}
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

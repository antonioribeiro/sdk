<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddBaseUrl extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::table('directories', function(Blueprint $table)
		{
			$table->string('base_url')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
        Schema::table('directories', function(Blueprint $table)
        {
            $table->dropColumn('base_url');
        });
	}
}

<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddWidthHeight extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::table('files', function(Blueprint $table)
		{
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
        Schema::table('files', function(Blueprint $table)
        {
            $table->dropColumn('width');
            $table->dropColumn('height');
        });
	}
}

<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFacebookPagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		// Roles
		Schema::create('facebook_pages', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('facebook_id');

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
		Schema::drop('facebook_pages');
    }
}

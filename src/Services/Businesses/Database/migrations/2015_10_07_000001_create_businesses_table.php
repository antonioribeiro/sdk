<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('businesses', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->string('name')->index();
			$table->uuid('avatar_id')->nullable();

			$table->timestamps();
		});
	}

	public function migrateDown()
	{
		Schema::drop('businesses');
	}
}

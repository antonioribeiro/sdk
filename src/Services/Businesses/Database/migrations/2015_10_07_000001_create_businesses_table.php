<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('businesses', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('name')->index();
			$table->string('avatar_id', 64)->nullable();

			$table->timestamps();
		});
	}

	public function migrateDown()
	{
		Schema::drop('businesses');
	}
}

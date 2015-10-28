<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessClientsTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('business_clients', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('business_id', 64);
			$table->string('name')->index();
			$table->string('avatar_id', 64)->nullable();

			$table->timestamps();
		});

		Schema::table('business_clients', function(Blueprint $table)
		{
			$table->foreign('business_id')
				->references('id')
				->on('businesses')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
	}

	public function migrateDown()
	{
		Schema::drop('business_clients');
	}
}

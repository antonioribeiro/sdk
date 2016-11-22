<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessClientsTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('business_clients', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('business_id');
			$table->string('name')->index();
			$table->uuid('avatar_id')->nullable();

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

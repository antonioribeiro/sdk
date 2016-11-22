<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessRolesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('business_roles', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('business_id');
			$table->string('name');
			$table->string('description');
			$table->integer('power')->default(256);

			$table->timestamps();
		});

		Schema::table('business_roles', function(Blueprint $table)
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
		Schema::drop('business_roles');
	}
}

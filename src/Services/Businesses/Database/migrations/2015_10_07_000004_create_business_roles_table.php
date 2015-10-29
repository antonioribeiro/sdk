<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBusinessRolesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('business_roles', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('business_id', 64);
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

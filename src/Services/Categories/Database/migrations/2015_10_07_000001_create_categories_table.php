<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCategoriesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();

			$table->string('name', 255);

			$table->string('parent_id', 64)->nullable();
			$table->integer('left')->nullable();
			$table->integer('right')->nullable();
			$table->integer('depth')->nullable();

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
		Schema::drop('categories');
	}
}

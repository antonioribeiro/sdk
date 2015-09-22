<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('roles', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->text('name');
			$table->text('description')->nullable();

			$table->timestamps();
		});

//		Schema::table('roles', function(Blueprint $table)
//		{
//			$table->foreign('category_id')
//					->references('id')
//					->on('roles_categories')
//					->onUpdate('cascade')
//					->onDelete('cascade');
//		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('roles');
	}

}

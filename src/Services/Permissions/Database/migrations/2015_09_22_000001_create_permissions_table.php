<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePermissionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('permissions', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->text('name');
			$table->text('description')->nullable();

			$table->timestamps();
		});

//		Schema::table('permissions', function(Blueprint $table)
//		{
//			$table->foreign('category_id')
//					->references('id')
//					->on('permissions_categories')
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
		Schema::drop('permissions');
	}

}

<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->text('name');
			$table->text('description')->nullable();
			$table->string('brand_id', 64);
			$table->string('category_id', 64);
			$table->string('unit_id', 64);
			$table->boolean('active')->default(true);
			$table->float('package_weight')->nullable();
			$table->integer('package_width')->nullable();
			$table->integer('package_height')->nullable();
			$table->integer('package_depth')->nullable();

			$table->timestamps();
		});

//		Schema::table('products', function(Blueprint $table)
//		{
//			$table->foreign('category_id')
//					->references('id')
//					->on('products_categories')
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
		Schema::drop('products');
	}

}

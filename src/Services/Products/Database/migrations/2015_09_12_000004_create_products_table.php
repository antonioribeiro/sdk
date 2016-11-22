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
			$table->uuid('id')->unique()->primary()->index();

			$table->text('name');
			$table->text('description')->nullable();
			$table->uuid('brand_id');
			$table->uuid('category_id');
			$table->uuid('unit_id');
			$table->boolean('active')->default(true);
			$table->float('package_weight')->nullable();
			$table->integer('package_width')->nullable();
			$table->integer('package_height')->nullable();
			$table->integer('package_depth')->nullable();

			$table->timestamps();
		});

		Schema::table('products', function(Blueprint $table)
		{
			$table->foreign('brand_id')
				->references('id')
				->on('products_brands')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('products', function(Blueprint $table)
		{
			$table->foreign('category_id')
					->references('id')
					->on('products_categories')
					->onUpdate('cascade')
					->onDelete('cascade');
		});

		Schema::table('products', function(Blueprint $table)
		{
			$table->foreign('unit_id')
				->references('id')
				->on('products_units')
				->onUpdate('cascade')
				->onDelete('cascade');
		});
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

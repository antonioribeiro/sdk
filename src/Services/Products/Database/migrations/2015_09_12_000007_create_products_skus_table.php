<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsSkusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('products_skus', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->integer('sku')->autoincrement();

			$table->string('product_id', 64)->index();
			$table->string('color_id')->nullable();
			$table->string('size_id')->nullable();
			$table->decimal('cost', 13, 2)->default(0);
			$table->decimal('price', 13, 2)->default(0);
			$table->integer('stock')->default(0);

			$table->timestamps();
		});

		Schema::table('products_skus', function(Blueprint $table)
		{
			$table->foreign('product_id')
					->references('id')
					->on('products')
					->onUpdate('cascade')
					->onDelete('cascade');
		});

		Schema::table('products_skus', function(Blueprint $table)
		{
			$table->foreign('color_id')
				->references('id')
				->on('products_options_values')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('products_skus', function(Blueprint $table)
		{
			$table->foreign('size_id')
				->references('id')
				->on('products_options_values')
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
		Schema::drop('products_skus');
	}
}

<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsOptionsValuesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('products_options_values', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('product_option_id');
			$table->string('name');

			$table->timestamps();
		});

		Schema::table('products_options_values', function(Blueprint $table)
		{
			$table->foreign('product_option_id')
					->references('id')
					->on('products_options')
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
		Schema::drop('products_options_values');
	}
}

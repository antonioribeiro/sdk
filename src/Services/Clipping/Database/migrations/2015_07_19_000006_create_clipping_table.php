<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClippingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('clipping', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->text('heading')->nullable();
			$table->text('subheading')->nullable();
			$table->text('body')->nullable();
			$table->string('url', 1024)->nullable();
			$table->string('article_preview_url', 1024)->nullable();
			$table->string('category_id', 64)->nullable()->index();
			$table->string('vehicle_id', 64)->nullable()->index();
			$table->string('author_id')->nullable()->index();
			$table->string('locality_id', 64)->nullable()->index();
			$table->timestamp('published_at')->nullable();
			$table->string('main_image_id', 64)->nullable();

			$table->timestamps();
		});

		Schema::table('clipping', function(Blueprint $table)
		{
			$table->foreign('category_id')
					->references('id')
					->on('clipping_categories')
					->onUpdate('cascade')
					->onDelete('cascade');
		});

		Schema::table('clipping', function(Blueprint $table)
		{
			$table->foreign('vehicle_id')
				->references('id')
				->on('clipping_vehicles')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('clipping', function(Blueprint $table)
		{
			$table->foreign('author_id')
				->references('id')
				->on('clipping_authors')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('clipping', function(Blueprint $table)
		{
			$table->foreign('locality_id')
				->references('id')
				->on('clipping_localities')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('clipping', function(Blueprint $table)
		{
			$table->foreign('main_image_id')
				->references('id')
				->on('files_names')
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
		Schema::drop('clipping');
	}

}

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
			$table->uuid('id')->unique()->primary()->index();

			$table->text('heading')->nullable();
			$table->text('subheading')->nullable();
			$table->text('body')->nullable();
			$table->string('url', 1024)->nullable();
			$table->string('article_preview_url', 1024)->nullable();
			$table->uuid('category_id')->nullable()->index();
			$table->uuid('vehicle_id')->nullable()->index();
			$table->uuid('author_id')->nullable()->index();
			$table->uuid('locality_id')->nullable()->index();
			$table->timestamp('published_at')->nullable();
			$table->uuid('main_image_id')->nullable();

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

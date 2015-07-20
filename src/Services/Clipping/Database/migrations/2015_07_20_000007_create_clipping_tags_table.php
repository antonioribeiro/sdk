<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClippingTagsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('clipping_tags', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('clipping_id', 64)->nullable();

			$table->string('tag_id', 64)->nullable();

			$table->timestamps();
		});

		Schema::table('clipping_tags', function(Blueprint $table)
		{
			$table->foreign('clipping_id')
				->references('id')
				->on('clipping')
				->onUpdate('cascade')
				->onDelete('cascade');
		});

		Schema::table('clipping_tags', function(Blueprint $table)
		{
			$table->foreign('tag_id')
				->references('id')
				->on('tags')
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
		Schema::drop('clipping_tags');
	}
}

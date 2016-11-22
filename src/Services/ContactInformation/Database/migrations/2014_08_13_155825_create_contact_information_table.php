<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateContactInformationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('contact_information', function(Blueprint $table)
		{
			$table->uuid('id')->primary();

			$table->uuid('user_id')->nullable();
			$table->uuid('kind_id');
			$table->string('info');

			$table->timestamps();
		});

		Schema::table('contact_information', function(Blueprint $table)
		{
			$table->foreign('user_id')
					->references('id')
					->on('users')
					->onUpdate('cascade')
					->onDelete('cascade');
		});

		Schema::table('contact_information', function(Blueprint $table)
		{
			$table->foreign('kind_id')
					->references('id')
					->on('kinds')
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
		Schema::drop('contact_information');
	}

}

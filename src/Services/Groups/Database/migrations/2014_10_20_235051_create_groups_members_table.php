<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupsMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('groups_members', function(Blueprint $table)
		{
			$table->string('id', 64)->index();
			$table->string('group_id', 64)->index();
			$table->string('group_role_id', 64)->index();
			$table->string('membership_id', 64)->index();
			$table->string('membership_type')->index();

			$table->timestamps();
		});

		Schema::table('groups_members', function(Blueprint $table)
		{
			$table->foreign('group_id')
					->references('id')
					->on('groups')
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
		Schema::drop('groups_members');
	}

}

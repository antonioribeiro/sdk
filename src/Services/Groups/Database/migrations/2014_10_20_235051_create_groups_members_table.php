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
			$table->uuid('id')->index();
			$table->uuid('group_id')->index();
			$table->uuid('group_role_id')->index();
			$table->uuid('membership_id')->index();
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

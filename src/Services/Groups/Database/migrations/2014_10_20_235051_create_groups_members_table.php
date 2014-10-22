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
			$table->string('group_id', 64)->index();
			$table->string('member_user_id', 64)->index()->nullable();
			$table->string('member_group_id', 64)->index()->nullable();
			$table->string('group_role_id', 64);

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

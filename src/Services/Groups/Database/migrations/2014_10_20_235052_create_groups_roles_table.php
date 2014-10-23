<?php

use PragmaRX\Sdk\Services\Groups\Data\Entities\GroupRole;
use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupsRolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('groups_roles', function(Blueprint $table)
		{
			$table->string('id', 64)->index();

			$table->string('name', 64)->index()->nullable();

			$table->timestamps();
		});

		$this->seedTable();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('groups_roles');
	}

	private function seedTable()
	{
		GroupRole::create(['name' => 'owner']);
		GroupRole::create(['name' => 'administrator']);
		GroupRole::create(['name' => 'member']);
	}

}

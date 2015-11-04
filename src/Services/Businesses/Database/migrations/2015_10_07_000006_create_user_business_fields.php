<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserBusinessFields extends Migration
{
	public function migrateUp()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('preferred_business_id', 64)->nullable();
		});
	}

	public function migrateDown()
	{
		$this->dropColumn('users', 'preferred_business_id');
	}
}

<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserBusinessFields extends Migration
{
	public function migrateUp()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->uuid('preferred_business_id')->nullable();
			$table->uuid('preferred_business_client_id')->nullable();
		});
	}

	public function migrateDown()
	{
		$this->dropColumn('users', 'preferred_business_id');
		$this->dropColumn('users', 'preferred_business_client_id');
	}
}

<?php

use PragmaRX\Sdk\Services\TwoFactor\Data\Entities\TwoFactorType;
use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTwoFactorTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('two_factor_types', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();

			$table->string('code', 32);
			$table->string('name', 64)->index();

			$table->timestamps();
		});

		TwoFactorType::create([
            'code' => 'g2fa',
	        'name' => 'Google Authenticator',
        ]);

		TwoFactorType::create([
			'code' => 'sms',
			'name' => 'SMS',
		]);

		TwoFactorType::create([
			'code' => 'email',
			'name' => 'E-mail',
		]);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('two_factor_types');
	}

}

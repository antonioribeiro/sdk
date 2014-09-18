<?php

use Illuminate\Database\Schema\Blueprint;
use PragmaRX\Support\Migration;

class AddTwoFactorToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('two_factor_recovery_code_a', 64)->nullable()->index();
			$table->string('two_factor_recovery_code_b', 64)->nullable()->index();

			$table->boolean('two_factor_google_enabled')->default(false);
			$table->string('two_factor_google_token', 64)->nullable()->index();
			$table->timestamp('two_factor_google_token_created_at')->nullable();
			$table->string('two_factor_google_secret_key',32)->nullable();

			$table->boolean('two_factor_sms_enabled')->default(false);
			$table->string('two_factor_sms_token', 16)->nullable()->index();
			$table->timestamp('two_factor_sms_token_created_at')->nullable();
			$table->string('two_factor_sms_secret_key',32)->nullable();

			$table->boolean('two_factor_email_enabled')->default(false);
			$table->string('two_factor_email_token', 16)->nullable()->index();
			$table->timestamp('two_factor_email_token_created_at')->nullable();
			$table->string('two_factor_email_secret_key',32)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		$this->dropColumn('users', 'two_factor_id');
		$this->dropColumn('users', 'google_authenticator_secret');
	}

}

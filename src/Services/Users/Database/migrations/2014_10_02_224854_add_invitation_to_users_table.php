<?php

use Illuminate\Database\Schema\Blueprint;
use PragmaRX\Support\Migration;

class AddInvitationToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->uuid('inviter_id')->nullable()->index();

			$table->timestamp('invited_at')->nullable();

			$table->timestamp('invitation_accepted_at')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		$this->dropColumn('users', 'inviter_id');

		$this->dropColumn('users', 'invited_at');

		$this->dropColumn('users', 'invitation_accepted_at');
	}

}

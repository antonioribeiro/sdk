<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesDebtorsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('invoices_debtors', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->uuid('invoice_id')->index();
			$table->uuid('debtor_id')->index();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('invoices_debtors');
	}

}

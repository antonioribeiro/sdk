<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('invoices_payments', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('invoice_id', 64)->index();
			$table->decimal('amount', 13, 2);
			$table->string('payer_id', 64)->index();

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
		Schema::drop('invoices_payments');
	}

}

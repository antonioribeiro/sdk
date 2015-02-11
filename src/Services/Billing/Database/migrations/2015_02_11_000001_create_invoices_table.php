<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('invoices', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('items_entity_id', 64);
			$table->string('creditor_entity_id', 64);
			$table->string('debtor_entity_id', 64);
			$table->string('currency_id', 64);
			$table->decimal('total', 13, 2);
			$table->timestamp('due_date')->nullable();
			$table->timestamp('fully_payed_at')->nullable();
			$table->text('notes');
			$table->timestamp('last_reminder')->nullable();

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
		Schema::drop('invoices');
	}

}

<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('invoices_items', function(Blueprint $table)
		{
			$table->string('id', 64)->unique()->primary()->index();

			$table->string('invoice_id', 64)->index();
			$table->string('item_id', 64)->index();
			$table->decimal('amount', 13, 2);

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
		Schema::drop('invoices_items');
	}

}

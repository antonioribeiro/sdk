<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;
use PragmaRX\Sdk\Services\Currencies\Data\Entities\Currency;

class CreateCurrenciesTable extends Migration {

	public static $generateId = false;

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('currencies', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();
			$table->string('name');
			$table->string('code', 5)->index();
			$table->string('symbol');
			$table->integer('decimals')->unsigned();
			$table->string('decimal_point');
			$table->string('thousands_separator');
			$table->timestamps();
		});

		Currency::create(['id' => 'BRL', 'name' => 'Real', 'code' => 'BRL', 'symbol' => 'R$', 'decimals' => 2, 'decimal_point' => ',', 'thousands_separator' => '.']);
		Currency::create(['id' => 'USD', 'name' => 'US Dollar', 'code' => 'USD', 'symbol' => '$', 'decimals' => 2, 'decimal_point' => '.', 'thousands_separator' => ',']);
		Currency::create(['id' => 'EUR', 'name' => 'Euro', 'code' => 'EUR', 'symbol' => '€', 'decimals' => 2, 'decimal_point' => '.', 'thousands_separator' => ',']);
		Currency::create(['id' => 'CHF', 'name' => 'Swiss franc', 'code' => 'CHF', 'symbol' => 'SFr.', 'decimals' => 2, 'decimal_point' => '.', 'thousands_separator' => "'"]);
		Currency::create(['id' => 'GPB', 'name' => 'Pound', 'code' => 'GBP', 'symbol' => '£', 'decimals' => 2, 'decimal_point' => '.', 'thousands_separator' => ',']);
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('currencies');
	}

}

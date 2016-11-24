<?php

use Illuminate\Database\Migrations\Migration;
use PragmaRX\Sdk\Services\Currencies\Data\Entities\Currency;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function($table)
        {
            $table->uuid('id')->primary();

            $table->string('code');
            $table->string('name');
            $table->string('symbol');
            $table->string('fractional_unit')->nullable();
            $table->string('number_to_basic')->nullable();
	        $table->integer('decimals')->nullable();
	        $table->string('decimal_point',3)->nullable();
	        $table->string('thousands_separator',3)->nullable();

            $table->timestamps();
        });

        $this->seedTable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }

    private function seedTable()
    {
        Currency::unguard();

        echo "Seeding currencies...\n";

        $currencies = require __DIR__.'/currencies.php';

        foreach ($currencies as $row) {
            Currency::create($row);
        }
    }
}

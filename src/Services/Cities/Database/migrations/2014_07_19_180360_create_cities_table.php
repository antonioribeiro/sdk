<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;
use PragmaRX\Sdk\Services\Cities\Data\Entities\City;
use PragmaRX\Sdk\Services\States\Data\Entities\State;
use PragmaRX\Sdk\Services\Countries\Data\Entities\Country;

class CreateCitiesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('cities', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();
			$table->string('name');
			$table->string('abbreviation')->nullable();
			$table->string('state_id', 64);
            $table->string('country_id', 64);
			$table->float('latitude')->nullable();
			$table->float('longitude')->nullable();
			$table->timestamps();
		});

		Schema::table('cities', function(Blueprint $table)
		{
			$table->foreign('state_id')
					->references('id')
					->on('states')
					->onUpdate('cascade')
					->onDelete('cascade');
		});

        $this->seedTable();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('cities');
	}

    private function seedTable()
    {
        $cities = require __DIR__.'/cities.php';

        $country = Country::where('code', 'BR')->first();
        $state = State::where('code', 'RJ')->first();

        foreach ($cities as $row) {
            if ($country->code != $row['country_id'])
            {
                $country = Country::where('code', $row['country_id'])->first();
            }

            if ($state->code != $row['state_id'])
            {
                $state = State::where('code', $row['state_id'])->first();
            }

            $row['country_id'] = $country->id;
            $row['state_id'] = $state->id;

            City::create($row);
        }
    }
}

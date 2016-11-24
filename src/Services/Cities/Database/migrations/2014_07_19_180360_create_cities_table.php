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
			$table->uuid('id')->primary();
			$table->string('name');
			$table->string('abbreviation')->nullable();
			$table->uuid('state_id');
            $table->uuid('country_id');
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
        echo "Seeding cities...\n";

        $cities = require get_class_path(City::class).'/../../Database/seeds/cities.php';

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

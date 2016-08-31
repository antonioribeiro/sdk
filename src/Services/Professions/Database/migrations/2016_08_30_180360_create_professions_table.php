<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;
use PragmaRX\Sdk\Services\Countries\Data\Entities\Country;
use PragmaRX\Sdk\Services\Professions\Data\Entities\Profession;

class CreateProfessionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('professions', function(Blueprint $table)
		{
			$table->string('id', 64)->primary();

            $table->string('name')->index();
            $table->string('code')->nullable()->index();
            $table->uuid('country_id')->nullable()->index();

			$table->timestamps();
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
		Schema::drop('professions');
	}

    private function seedTable()
    {
        $professions = file(__DIR__.'/professions.txt');

        $country = Country::where('code', 'BR')->first();

        foreach ($professions as $row)
        {
            $row = utf8_encode($row);

            $row = trim(str_replace (array("\r\n", "\n", "\r"), ' ', $row));

            $data = [
                'code' => substr($row, 0, 6),
                'name' => substr($row, 7),
                'country_id' => $country->id,
            ];

            Profession::create($data);
        }
    }
}

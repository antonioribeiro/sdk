<?php

use PragmaRX\Sdk\Services\Languages\Data\Entities\CountryLanguage;
use PragmaRX\Sdk\Services\Countries\Data\Entities\Country;
use PragmaRX\Sdk\Services\Languages\Data\Entities\Language;
use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountryLanguagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('country_languages', function(Blueprint $table)
		{
			$table->uuid('id')->primary();

            $table->uuid('language_id');
            $table->uuid('country_id');
            $table->string('regional_name');
            $table->boolean('enabled')->default(false);

            $table->unique('regional_name');

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
		Schema::drop('country_languages');
	}

    private function seedTable()
    {
        echo "Seeding countries languages...\n";

        CountryLanguage::unguard();

        $country_languages = require get_class_path(Language::class).'/../../Database/seeds/country_languages.php';

        foreach ($country_languages as $row) {
            if (! $country = Country::where('code', $row['country_id'])->first())
            {
                dd($row['country_id']);
            }

            if (! $language = Language::where('code', $row['language_id'])->first())
            {
                dd($row['language_id']);
            }

            CountryLanguage::create([
                'language_id' => $language->id,
                'country_id' => $country->id,
                'regional_name' => $row['regional_name'],
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ]);
        }
    }
}

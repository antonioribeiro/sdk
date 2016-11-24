<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;
use PragmaRX\Sdk\Services\Languages\Data\Entities\Language;

class CreateLanguagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('languages', function(Blueprint $table)
		{
			$table->uuid('id')->primary();

            $table->string('code');
            $table->string('english_name')->nullable();
            $table->string('arabic_name')->nullable();
            $table->string('native_name')->nullable();
            $table->string('language_family')->nullable();
            $table->string('alphabet')->nullable();
            $table->string('code_639_1')->nullable();
            $table->string('code_639_2_T')->nullable();
            $table->string('code_639_2_B')->nullable();
            $table->string('code_639_3')->nullable();
            $table->string('code_639_6')->nullable();
            $table->string('Notes')->nullable();

			$table->timestamps();
		});

        $this->seedLanguagesTable();
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function migrateDown()
	{
		Schema::drop('languages');
	}

    private function seedLanguagesTable()
    {
        echo "Seeding languages...\n";

        Language::unguard();

        $languages = require get_class_path(Language::class).'/../../Database/seeds/languages_1.php';

        foreach ($languages as $row) {
            Language::create([
                'code' => $row['id'],
                'english_name' => $row['name'],
                'alphabet' => $row['alphabet'],
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
            ]);
        }

        $languages = require get_class_path(Language::class).'/../../Database/seeds/languages_2.php';

        foreach ($languages as $row) {
            $lang = [
                'code' => $row[4],
                'english_name' => $row[0],
                'arabic_name' => $row[1],
                'native_name' => $row[2],
                'language_family' => $row[3],
                'code_639_1' => $row[4],
                'code_639_2_T' => $row[5],
                'code_639_2_B' => $row[6],
                'code_639_3' => $row[7],
                'code_639_6' => $row[8],
                'Notes' => $row[9],
            ];

            if (! $language = Language::where('code', $row[4])->first())
            {
                $language = new Language();
            }

            $language->fill($lang);

            $language->save();
        }
    }
}

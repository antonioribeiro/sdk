<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;
use PragmaRX\Sdk\Services\DegreeLevels\Data\Entities\DegreeLevel;

class CreateDegreeLevelsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('degree_levels', function(Blueprint $table)
		{
			$table->uuid('id')->primary();
			$table->string('name');
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
		Schema::drop('degree_levels');
	}

    private function seedTable()
    {
        $degrees = [
            ['name' => 'Educação infantil (pré-escolar)'],
            ['name' => 'Ensino fundamental (primário - 1º grau)'],
            ['name' => 'Ensino médio (secundário - 2º grau)'],
            ['name' => 'Educação superior (ensino superior - 3º grau)'],
            ['name' => 'Pós-Graduação'],
            ['name' => 'Mestrado'],
            ['name' => 'Doutorado'],
        ];

        foreach ($degrees as $row) {
            DegreeLevel::create($row);
        }
    }
}

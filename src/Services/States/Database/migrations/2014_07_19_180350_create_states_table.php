<?php

use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;
use PragmaRX\Sdk\Services\States\Data\Entities\State;
use PragmaRX\Sdk\Services\Countries\Data\Entities\Country;

class CreateStatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function migrateUp()
	{
		Schema::create('states', function(Blueprint $table)
		{
			$table->uuid('id')->primary();
			$table->string('code', 5);
			$table->string('name')->nullable();
			$table->uuid('country_id');
			$table->float('latitude')->nullable();
			$table->float('longitude')->nullable();
			$table->timestamps();
		});

		Schema::table('states', function(Blueprint $table)
		{
			$table->foreign('country_id')
					->references('id')
					->on('countries')
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
		Schema::drop('states');
	}

    private function seedTable()
    {
        $states = [
            ['country_id' => 'BR', 'code' => 'AC', 'name' => 'Acre', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'AL', 'name' => 'Alagoas', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'AP', 'name' => 'Amapá', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'AM', 'name' => 'Amazonas', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'BA', 'name' => 'Bahia', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'CE', 'name' => 'Ceará', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'DF', 'name' => 'Distrito Federal', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'ES', 'name' => 'Espírito Santo', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'GO', 'name' => 'Goiás', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'MA', 'name' => 'Maranhão', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'MT', 'name' => 'Mato Grosso', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'MS', 'name' => 'Mato Grosso do Sul', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'MG', 'name' => 'Minas Gerais', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'PA', 'name' => 'Pará', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'PB', 'name' => 'Paraíba', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'PR', 'name' => 'Paraná', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'PE', 'name' => 'Pernambuco', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'PI', 'name' => 'Piauí', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'RR', 'name' => 'Roraima', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'RO', 'name' => 'Rondônia', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'RJ', 'name' => 'Rio de Janeiro', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'RN', 'name' => 'Rio Grande do Norte', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'RS', 'name' => 'Rio Grande do Sul', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'SC', 'name' => 'Santa Catarina', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'SP', 'name' => 'São Paulo', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'SE', 'name' => 'Sergipe', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['country_id' => 'BR', 'code' => 'TO', 'name' => 'Tocantins', 'created_at' => new DateTime, 'updated_at' => new DateTime],
        ];

        $country = Country::where('code', 'BR')->first();

        foreach ($states as $row) {
            if ($country->code != $row['country_id'])
            {
                $country = Country::where('code', $row['country_id'])->first();
            }

            $row['country_id'] = $country->id;

            State::create($row);
        }
    }
}

<?php

use PragmaRX\Sdk\Services\Chat\Data\Entities\ChatScriptType;
use PragmaRX\Support\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChatScriptTypesTable extends Migration
{
	public function migrateUp()
	{
		Schema::create('chat_script_types', function(Blueprint $table)
		{
			$table->uuid('id')->unique()->primary()->index();

			$table->text('name')->index();
			$table->text('description')->index();

			$table->timestamps();
		});

		$this->preSeedTable();
	}

	public function migrateDown()
	{
		Schema::drop('chat_script_types');
	}

	private function preSeedTable()
	{
		ChatScriptType::create(['name' => 'opening', 'description' => 'Abertura']);
		ChatScriptType::create(['name' => 'script', 'description' => 'Script']);
		ChatScriptType::create(['name' => 'closing', 'description' => 'Fechamento']);
	}
}

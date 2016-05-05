<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class ChatScriptType extends Model
{
	protected $table = 'chat_script_types';

	protected $fillable = [
		'name',
	    'description'
	];
}

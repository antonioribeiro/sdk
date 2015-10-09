<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ChatClient extends Model
{
	protected $table = 'chat_clients';

	protected $fillable = [
		'name',
	];
}

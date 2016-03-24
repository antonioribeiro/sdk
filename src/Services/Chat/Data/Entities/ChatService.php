<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ChatService extends Model
{
	protected $table = 'chat_services';

	protected $fillable = [
		'name',
	];
}

<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ChatBusinessClients extends Model
{
	protected $table = 'chat_business_clients';

	protected $fillable = [
		'chat_business_id',
		'name',
	];
}

<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ChatClientService extends Model
{
	protected $table = 'chat_client_services';

	protected $fillable = [
		'chat_business_client_id',
		'user_id',
		'phone_id',
	];
}

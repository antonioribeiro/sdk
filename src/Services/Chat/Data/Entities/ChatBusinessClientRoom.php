<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ChatBusinessClientRoom extends Model
{
	protected $table = 'chat_business_client_rooms';

	protected $fillable = [
		'chat_client_service_id'
		'chat_business_client_id',
		'name',
	];
}

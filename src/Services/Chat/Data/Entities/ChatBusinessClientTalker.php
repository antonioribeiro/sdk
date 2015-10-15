<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ChatBusinessClientTalker extends Model
{
	protected $table = 'chat_business_client_talkers';

	protected $fillable = [
		'chat_business_client_id',
		'user_id',
		'phone_id',
	];
}

<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ChatMessage extends Model
{
	protected $table = 'chat_messages';

	protected $fillable = [
		'chat_id',
		'chat_business_client_talker_id',
		'message',
	];
}

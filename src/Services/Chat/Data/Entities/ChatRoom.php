<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ChatRoom extends Model
{
	protected $table = 'chat_rooms';

	protected $fillable = [
		'chat_customer_id',
		'name',
	];
}

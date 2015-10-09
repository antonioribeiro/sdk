<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ChatBusiness extends Model
{
	protected $table = 'chat_businesses';

	protected $fillable = [
		'name',
	];
}

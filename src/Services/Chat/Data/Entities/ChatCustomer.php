<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ChatCustomer extends Model
{
	protected $table = 'chat_clients';

	protected $fillable = [
		'chat_business_id',
		'name',
	];
}

<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class ChatScript extends Model
{
	protected $table = 'chat_scripts';

	protected $fillable = [
		'business_client_id',
		'chat_service_id',
		'message',
	];

	protected $presenter = 'PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatPresenter';
}

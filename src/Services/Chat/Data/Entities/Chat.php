<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class Chat extends Model
{
	protected $table = 'chats';

	protected $fillable = [
		'client_id',
		'user_id',
	];

	protected $presenter = 'PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatPresenter';
}

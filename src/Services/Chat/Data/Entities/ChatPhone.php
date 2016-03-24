<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatPhone as ChatPhonePresenter;

class ChatPhone extends Model
{
	protected $table = 'chat_phones';

	protected $fillable = [
		'number',
	];

	protected $presenter = ChatPhonePresenter::class;
}

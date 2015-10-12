<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use App\Services\Users\Data\Entities\User;
use PragmaRX\Sdk\Core\Model;

class ChatPhone extends Model
{
	protected $table = 'chat_phones';

	protected $fillable = [
		'number',
	];

	protected $presenter = 'PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatPresenter';
}

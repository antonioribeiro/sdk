<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use App\Services\Users\Data\Entities\User;
use PragmaRX\Sdk\Core\Model;

class ChatService extends Model
{
	protected $table = 'chat_services';

	protected $fillable = [
		'name',
	];

	protected $presenter = 'PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatPresenter';
}

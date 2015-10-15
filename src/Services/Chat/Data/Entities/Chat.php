<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use App\Services\Users\Data\Entities\User;
use PragmaRX\Sdk\Core\Model;

class Chat extends Model
{
	protected $table = 'chats';

	protected $fillable = [
		'chat_business_client_service_room_id',
		'owner_id',
	];

	protected $presenter = 'PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatPresenter';

	public function owner()
	{
		return $this->belongsTo(User::class, 'owner_id');
	}
}

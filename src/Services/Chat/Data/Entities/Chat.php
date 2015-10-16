<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

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
		return $this->belongsTo(ChatBusinessClientTalker::class, 'owner_id');
	}
}

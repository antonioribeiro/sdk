<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use App\Services\Users\Data\Entities\User;

class Chat extends Model
{
	protected $table = 'chats';

	protected $fillable = [
		'chat_business_client_service_id',
		'owner_id',
	];

	protected $presenter = 'PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatPresenter';

	public function owner()
	{
		return $this->belongsTo(ChatBusinessClientTalker::class, 'owner_id');
	}

	public function responder()
	{
		return $this->belongsTo(User::class, 'responder_id');
	}

	public function service()
	{
		return $this->belongsTo(ChatBusinessClientService::class, 'chat_business_client_service_id');
	}
}

<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Chat\Data\Presenters\Chat as ChatPresenter;

class Chat extends Model
{
	protected $table = 'chats';

	protected $fillable = [
		'chat_business_client_service_id',
		'owner_id',
		'owner_ip_address',
	    'closed_at',
        'layout',
	];

	protected $presenter = ChatPresenter::class;

	public function owner()
	{
		return $this->belongsTo(ChatBusinessClientTalker::class, 'owner_id');
	}

	public function responder()
	{
		return $this->belongsTo(ChatBusinessClientTalker::class, 'responder_id');
	}

	public function service()
	{
		return $this->belongsTo(ChatBusinessClientService::class, 'chat_business_client_service_id');
	}

	public function messages()
	{
		return $this->hasMany(ChatMessage::class);
	}
}

<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramChat;
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
        'telegram_chat_id',
	];

    protected $dates = [
        'created_at',
        'update_at',
        'last_message_at',
        'opened_at',
        'closed_at',
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

    public function telegramChat()
    {
        return $this->belongsTo(TelegramChat::class, 'telegram_chat_id');
    }
}

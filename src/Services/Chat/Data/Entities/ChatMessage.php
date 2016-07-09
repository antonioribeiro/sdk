<?php

namespace PragmaRX\Sdk\Services\Chat\Data\Entities;

use PragmaRX\Sdk\Services\Telegram\Data\Entities\TelegramMessage;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities\FacebookMessengerMessage;
use PragmaRX\Sdk\Services\Chat\Data\Presenters\ChatMessage as ChatMessagePresenter;

class ChatMessage extends BaseChatMessageModel
{
	protected $table = 'chat_messages';

	protected $fillable = [
		'chat_id',
		'chat_business_client_talker_id',
		'talker_ip_address',
		'message',
        'telegram_message_id',
        'facebook_messenger_message_id'
	];

    protected $presenter = ChatMessagePresenter::class;

	public function talker()
	{
		return $this->belongsTo(ChatBusinessClientTalker::class, 'chat_business_client_talker_id');
	}

    public function sender()
    {
        if ($this->telegram_message_id)
        {
            return $this->telegramMessage->sender();
        }

        if ($this->facebook_messenger_message_id)
        {
            return $this->facebookMessengerMessage->sender();
        }

        return $this->talker();
	}

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function facebookMessengerMessage()
    {
        return $this->belongsTo(FacebookMessengerMessage::class, 'facebook_messenger_message_id');
    }

    public function telegramMessage()
    {
        return $this->belongsTo(TelegramMessage::class, 'telegram_message_id');
    }
}

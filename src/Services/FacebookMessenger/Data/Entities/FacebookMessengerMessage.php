<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Services\Chat\Data\Entities\BaseChatMessageModel;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Presenters\FacebookMessengerMessage as FacebookMessengerMessagePresenter;

class FacebookMessengerMessage extends BaseChatMessageModel
{
	protected $table = 'facebook_messenger_messages';

    protected $presenter = FacebookMessengerMessagePresenter::class;

    protected $fillable = [
        'chat_id',
        'mid',
        'seq',
        'sender_id',
        'recipient_id',
        'time',
        'timestamp',
        'text',
        'attachments',
    ];

    public function chat()
    {
        return $this->belongsTo(FacebookMessengerChat::class);
    }

    public function from()
    {
        return $this->belongsTo(FacebookMessengerUser::class, 'sender_id');
    }

    public function to()
    {
        return $this->belongsTo(FacebookMessengerUser::class, 'recipient_id');
    }

    public function user()
    {
        return $this->from();
    }

    public function sender()
    {
        return $this->from();
    }
}

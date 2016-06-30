<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class FacebookMessengerChat extends Model
{
	protected $table = 'facebook_messenger_chats';

    protected $fillable = [
        'facebook_messenger_id',
        'bot_id',
        'title',
        'username',
        'first_name',
        'last_name',
    ];

    public function bot()
    {
        return $this->belongsTo(FacebookMessengerBot::class);
    }
}

<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class TelegramChat extends Model
{
	protected $table = 'telegram_chats';

    protected $fillable = [
        'telegram_id',
        'bot_id',
        'telegram_chat_type_id',
        'title',
        'username',
        'first_name',
        'last_name',
    ];

    public function bot()
    {
        return $this->belongsTo(TelegramBot::class);
    }
}

<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class TelegramChatType extends Model
{
	protected $table = 'telegram_chat_types';

	protected $fillable = ['name'];

}

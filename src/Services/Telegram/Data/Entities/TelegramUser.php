<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class TelegramUser extends Model
{
	protected $table = 'telegram_users';

	protected $fillable = [
        'telegram_id',
        'first_name',
        'last_name',
        'username',
    ];
}

<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class TelegramBot extends Model
{
	protected $table = 'telegram_bots';

    protected $fillable = [
        'name',
        'token',
    ];
}

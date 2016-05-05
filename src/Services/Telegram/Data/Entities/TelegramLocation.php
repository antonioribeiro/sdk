<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class TelegramLocation extends Model
{
	protected $table = 'telegram_locations';

    protected $fillable = [
        'longitude',
        'latitude',
    ];
}

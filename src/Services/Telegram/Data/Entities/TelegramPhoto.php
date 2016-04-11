<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class TelegramPhoto extends Model
{
	protected $table = 'telegram_photos';

    protected $fillable = [
        'telegram_file_id',
        'width',
        'height',
        'file_size',
    ];
}

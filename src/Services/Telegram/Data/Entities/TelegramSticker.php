<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class TelegramSticker extends Model
{
	protected $table = 'telegram_stickers';

    protected $fillable = [
        'telegram_file_id',
        'width',
        'height',
        'thumb_id',
        'file_size',
    ];
}

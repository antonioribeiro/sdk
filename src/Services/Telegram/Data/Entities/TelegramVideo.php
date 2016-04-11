<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class TelegramVideo extends Model
{
	protected $table = 'telegram_videos';

    protected $fillable = [
        'telegram_file_id',
        'width',
        'height',
        'duration',
        'thumb_id',
        'mime_type',
        'file_size',
    ];
}

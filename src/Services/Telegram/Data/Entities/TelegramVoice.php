<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class TelegramVoice extends Model
{
	protected $table = 'telegram_voices';

    protected $fillable = [
        'telegram_file_id',
        'duration',
        'mime_type',
        'file_size',
    ];
}

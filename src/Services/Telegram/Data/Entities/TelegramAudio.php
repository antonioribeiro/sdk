<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class TelegramAudio extends Model
{
	protected $table = 'telegram_audios';

    protected $fillable = [
        'telegram_file_id',
        'duration',
        'performer',
        'title',
        'mime_type',
        'file_size',
    ];
}

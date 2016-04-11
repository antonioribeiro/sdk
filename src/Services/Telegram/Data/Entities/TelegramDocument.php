<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Model;

class TelegramDocument extends Model
{
	protected $table = 'telegram_documents';

    protected $fillable = [
        'telegram_file_id',
        'thumb_id',
        'file_name',
        'mime_type',
        'file_size',
    ];
}

<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;

class TelegramSticker extends Model
{
	protected $table = 'telegram_stickers';

    protected $fillable = [
        'telegram_file_id',
        'file_name_id',
        'width',
        'height',
        'thumb_id',
        'file_size',
    ];

    public function fileName()
    {
        return $this->belongsTo(FileName::class);
    }
}

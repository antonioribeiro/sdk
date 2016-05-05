<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;

class TelegramVideo extends Model
{
	protected $table = 'telegram_videos';

    protected $fillable = [
        'telegram_file_id',
        'file_name_id',
        'width',
        'height',
        'duration',
        'thumb_id',
        'mime_type',
        'file_size',
    ];

    public function fileName()
    {
        return $this->belongsTo(FileName::class);
    }
}

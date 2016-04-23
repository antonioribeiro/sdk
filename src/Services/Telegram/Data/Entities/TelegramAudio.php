<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;

class TelegramAudio extends Model
{
	protected $table = 'telegram_audios';

    protected $fillable = [
        'telegram_file_id',
        'file_name_id',
        'duration',
        'performer',
        'title',
        'mime_type',
        'file_size',
    ];

    public function fileName()
    {
        return $this->belongsTo(FileName::class);
    }
}

<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;

class TelegramFile extends Model
{
	protected $table = 'telegram_files';

    protected $fillable = [
        'telegram_file_id',
        'file_name_id',
        'file_size',
        'file_path',
    ];

    public function fileName()
    {
        return $this->belongsTo(FileName::class);
    }
}

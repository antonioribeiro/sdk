<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;

class TelegramDocument extends Model
{
	protected $table = 'telegram_documents';

    protected $fillable = [
        'telegram_file_id',
        'file_name_id',
        'thumb_id',
        'file_name',
        'mime_type',
        'file_size',
    ];

    public function fileName()
    {
        return $this->belongsTo(FileName::class);
    }

    public function thumb()
    {
        return $this->belongsTo(TelegramPhoto::class);
    }
}

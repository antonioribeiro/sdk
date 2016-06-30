<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;

class FacebookMessengerSticker extends Model
{
	protected $table = 'facebook_messenger_stickers';

    protected $fillable = [
        'facebook_messenger_file_id',
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

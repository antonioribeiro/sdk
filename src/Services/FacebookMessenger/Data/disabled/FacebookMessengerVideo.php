<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;

class FacebookMessengerVideo extends Model
{
	protected $table = 'facebook_messenger_videos';

    protected $fillable = [
        'facebook_messenger_file_id',
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

<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;

class FacebookMessengerVoice extends Model
{
	protected $table = 'facebook_messenger_voices';

    protected $fillable = [
        'facebook_messenger_file_id',
        'file_name_id',
        'duration',
        'mime_type',
        'file_size',
    ];

    public function fileName()
    {
        return $this->belongsTo(FileName::class);
    }
}

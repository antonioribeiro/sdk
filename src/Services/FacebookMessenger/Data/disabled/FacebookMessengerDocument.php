<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;

class FacebookMessengerDocument extends Model
{
	protected $table = 'facebook_messenger_documents';

    protected $fillable = [
        'facebook_messenger_file_id',
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
        return $this->belongsTo(FacebookMessengerPhoto::class);
    }
}

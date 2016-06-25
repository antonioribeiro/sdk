<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;

class FacebookMessengerFile extends Model
{
	protected $table = 'facebook_messenger_files';

    protected $fillable = [
        'facebook_messenger_file_id',
        'file_name_id',
        'file_size',
        'file_path',
    ];

    public function fileName()
    {
        return $this->belongsTo(FileName::class);
    }
}

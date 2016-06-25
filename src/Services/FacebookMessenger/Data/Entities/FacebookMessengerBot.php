<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class FacebookMessengerBot extends Model
{
	protected $table = 'facebook_messenger_bots';

    protected $fillable = [
        'name',
        'token',
    ];
}

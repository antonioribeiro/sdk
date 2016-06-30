<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class FacebookMessengerLocation extends Model
{
	protected $table = 'facebook_messenger_locations';

    protected $fillable = [
        'longitude',
        'latitude',
    ];
}

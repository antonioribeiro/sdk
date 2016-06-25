<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class FacebookMessengerContact extends Model
{
	protected $table = 'facebook_messenger_contacts';

    protected $fillable = [
        'phone_number',
        'first_name',
        'last_name',
        'facebook_messenger_user_id',
    ];
}

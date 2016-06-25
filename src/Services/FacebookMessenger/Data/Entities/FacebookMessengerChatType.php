<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class FacebookMessengerChatType extends Model
{
	protected $table = 'facebook_messenger_chat_types';

	protected $fillable = ['name'];

}

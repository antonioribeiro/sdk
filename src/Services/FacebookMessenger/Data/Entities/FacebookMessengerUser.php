<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;

class FacebookMessengerUser extends Model
{
	protected $table = 'facebook_messenger_users';

	protected $fillable = [
        'facebook_messenger_id',
        'first_name',
        'last_name',
        'username',
        'avatar_url',
    ];

    public function getEmailAttribute()
    {
        return $this->facebook_messenger_id.'@facebook.me';
    }

    public function getHasAvatarAttribute()
    {
        return ! is_null($this->avatar_id);
    }

    public function avatar()
    {
        return $this->belongsTo(FileName::class);
    }
}

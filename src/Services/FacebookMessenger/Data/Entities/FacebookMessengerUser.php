<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\FacebookMessenger\Data\Presenters\FacebookMessengerUser as FacebookMessengerUserPresenter;

class FacebookMessengerUser extends Model
{
	protected $table = 'facebook_messenger_users';

	protected $fillable = [
        'facebook_messenger_id',
        'name',
        'first_name',
        'last_name',
        'profile_pic',
        'locale',
        'timezone',
        'gender',
    ];

    protected $presenter = FacebookMessengerUserPresenter::class;

    public function getEmailAttribute()
    {
        return $this->facebook_messenger_id.'@facebook.me';
    }

    public function getHasAvatarAttribute()
    {
        return ! is_null($this->avatar_id);
    }

    public function getAvatarAttribute()
    {
        return $this->profile_pic;
    }
}

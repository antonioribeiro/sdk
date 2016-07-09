<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;
use PragmaRX\Sdk\Services\Files\Data\Entities\FileName;
use PragmaRX\Sdk\Services\Telegram\Data\Presenters\TelegramUser as TelegramUserPresenter;

class TelegramUser extends Model
{
	protected $table = 'telegram_users';

	protected $fillable = [
        'telegram_id',
        'first_name',
        'last_name',
        'username',
        'avatar_url',
    ];

    protected $presenter = TelegramUserPresenter::class;

    public function getEmailAttribute()
    {
        return $this->telegram_id.'@telegram.me';
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

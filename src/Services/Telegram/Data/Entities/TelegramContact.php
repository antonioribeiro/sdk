<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class TelegramContact extends Model
{
	protected $table = 'telegram_contacts';

    protected $fillable = [
        'phone_number',
        'first_name',
        'last_name',
        'telegram_user_id',
    ];
}

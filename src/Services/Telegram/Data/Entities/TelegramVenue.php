<?php

namespace PragmaRX\Sdk\Services\Telegram\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class TelegramVenue extends Model
{
	protected $table = 'telegram_venues';

    protected $fillable = [
        'location_id',
        'title',
        'address',
        'foursquare_id',
    ];
}

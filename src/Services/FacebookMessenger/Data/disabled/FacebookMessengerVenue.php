<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class FacebookMessengerVenue extends Model
{
	protected $table = 'facebook_messenger_venues';

    protected $fillable = [
        'location_id',
        'title',
        'address',
        'foursquare_id',
    ];
}

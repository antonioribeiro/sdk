<?php

namespace PragmaRX\Sdk\Services\FacebookMessenger\Data\Entities;

use PragmaRX\Sdk\Core\Database\Eloquent\Model;

class FacebookPage extends Model
{
	protected $table = 'facebook_pages';

    protected $fillable = [
        'facebook_id',
    ];
}

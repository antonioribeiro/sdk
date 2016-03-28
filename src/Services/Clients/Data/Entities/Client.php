<?php

namespace PragmaRX\Sdk\Services\Clients\Data\Entities;

use Carbon;
use Language;
use PragmaRX\Sdk\Services\Users\Data\Entities\User;

class Client extends User
{
	protected $table = 'users';

	protected static function boot()
	{
		static::addGlobalScope(new ClientScope);

		parent::boot();
	}

	public function scopeHavingAsProvider($query, $provider)
    {
	    if ($provider instanceof User)
	    {
		    $provider = $provider->id;
	    }

        return $query
	            ->where('provider_id', $provider);
    }

	public function getBirthdateAttribute($value)
	{
		return ! $value
				? null
				: Carbon::createFromFormat('Y-m-d', $value)
					->format(Language::getCarbonDateFormat());
	}

}
